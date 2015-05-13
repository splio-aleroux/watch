var localStorageService = require('./LocalStorageService');
var _ = require('underscore');
var assign = require('object-assign');
var sha1 = require('sha1');
var base64 = require('base-64');
var requestService = require('./requestService');
var qs = require('qs');

var AUTHENTICATION_IDENTIFIER = "splio-watch-auth";
var AUTHENTICATION_REDIRECT_URL = "/auth/login";
var AUTHENTICATION_AUTH_URL = "/auth/oauth";

var AuthenticationService = {
    keys: {},
    /**
     * Initialize the service
     * @return {void} [init]
     */
    init: function() {
        this.keys = localStorageService.getValues(AUTHENTICATION_IDENTIFIER);
    },
    /**
     * Check if the request contains the auth keys
     * @return {Boolean} [description]
     */
    parseRequest: function() {
        var queryString = qs.parse(window.location.search.substring(1));
        if (
            _.has(queryString, 'public')
            && null !== queryString.public
            && _.has(queryString, 'secret')
            && null !== queryString.secret
        ) {
            this.saveKeys(queryString.public, queryString.secret);

            window.location.href = window.location.origin
        }

        return false;
    },
    /**
     * Is the user authenticated ?
     * @return {Boolean} [description]
     */
    isAuthenticated: function() {
        var keys = localStorageService.getValues(AUTHENTICATION_IDENTIFIER);
        return (
            _.has(keys, 'public')
            && undefined !== keys.public
            && _.has(keys, 'secret')
            && undefined !== keys.secret
        );
    },
    /**
     * Save keys in localstorage
     * @param  {string} public  The public key
     * @param  {string} secret  The secret key
     * @return {void}        [description]
     */
    saveKeys: function(public, secret) {
        this.keys = {
            'public': public,
            'secret': secret
        }

        localStorageService.setValues(AUTHENTICATION_IDENTIFIER, this.keys);
    },
    /**
     * Get keys from localstorage
     * @return {[object]}
     */
    getKeys: function() {
        this.keys = localStorageService.getValues(AUTHENTICATION_IDENTIFIER);

        return this.keys;
    },
    /**
     * Authenticate with back-end
     * @return {[type]}
     */
    authenticate: function() {
        var url = requestService.computeUrl(AUTHENTICATION_REDIRECT_URL);
        window.location = url;
    },
    /**
     * Compute WSSE key
     * @return {object}
     */
    computeWsseKey: function() {
        this.init();
        var createdAt = (new Date()).toString();
        var nonce = Math.random() * Math.pow(10, 9);
        nonce += createdAt;
        nonce = sha1(nonce);
        var digest = base64.encode(sha1(nonce+createdAt+this.keys.secret));

        return {
            "createdAt":  createdAt,
            "nonce": nonce,
            "digest": digest
        }
    },
    /**
     * Stringify the WSSE key to be passed in request header
     * @param  {object} wsseKey  The values to stringify
     * @return {string}          The WSSE phrase
     */
    stringifyWsseKey: function(wsseKey) {
        var wssePhrase = 'UsernameToken Username="'+this.keys.public+'"';
            wssePhrase += ', PasswordDigest="'+wsseKey.digest+'"';
            wssePhrase += ', Nonce="'+wsseKey.nonce+'"';
            wssePhrase += ', Created="'+wsseKey.createdAt+'"';

        return wssePhrase;
    },
    /**
     * Compute and return the stringified WSSE key
     * @return {string}     The WSSE phrase
     */
    getWssePhrase: function() {
        return this.stringifyWsseKey(this.computeWsseKey());
    }
};

module.exports = AuthenticationService;
