var localStorageService = require('./LocalStorageService');
var _ = require('underscore');
var assign = require('object-assign');
var sha1 = require('sha1');
var base64 = require('base-64');
var request = require('request');

var AUTHENTICATION_IDENTIFIER = "splio-watch-auth";
var AUTHENTICATION_REDIRECT_URL = "auth/login";
var AUTHENTICATION_AUTH_URL = "auth/oauth";


var AuthenticationService = {
    keys: {},
    checkRequest: function() {
        var queryString = window.location.search.substr(1);
        var regex = RegExp('([\d\w]+)&{1}([\d\w]+)$');
        var query = queryString.split('&');
    },
    hasKeys: function() {
        var keys = localStorageService.getValues(AUTHENTICATION_IDENTIFIER);
        return (
            _.has(keys, 'public')
            && undefined !== keys.public
            && _.has(keys, 'secret')
            && undefined !== keys.secret
        );
    },

    saveKeys: function(public, secret) {
        this.keys = {
            'public': public,
            'secret': secret
        }

        localStorageService.setValues(AUTHENTICATION_IDENTIFIER, this.keys);
    },

    getKeys: function(public, secret) {
        this.keys = localStorageService.getValues(AUTHENTICATION_IDENTIFIER);

        return this.keys;
    },

    auth: function() {
        // If there is no key, redirect to login URL
        if (!this.hasKeys()) {
            var url = this.computeUrl(AUTHENTICATION_REDIRECT_URL);

            window.location = url;

            // window.location.href = AUTHENTICATION_REDIRECT_URL;
        } else {
            // Check with back-end if everything is OK
            var wsseKey = this.computeWsseKey();
            var wssePhrase = this.stringifyWsseKey(wsseKey);

            var url = this.computeUrl(AUTHENTICATION_AUTH_URL);

            var options = {
                "method": "POST",
                "url": url,
                "headers": {
                    'X-WSSE': wssePhrase
                }
            }
        }
    },

    computeWsseKey: function() {
        var createdAt = (new Date()).toString();
        var nonce = Math.random() * Math.pow(10, 9);
        nonce += createdAt;
        var digest = base64.encode(sha1(nonce+createdAt+this.keys.secret));

        return {
            "createdAt":  createdAt,
            "nonce": nonce,
            "digest": digest
        }
    },

    stringifyWsseKey: function(wsseKey) {
        var wssePhrase = 'UsernameToken Username="'+this.keys.public+'"';
            wssePhrase += ', PasswordDigest="'+wsseKey.digest+'"';
            wssePhrase += ', Nonce="'+wsseKey.nonce+'"';
            wssePhrase += ', Created="'+wsseKey.createdAt;

        return wssePhrase;
    },

    getWssePhrase: function() {
        return this.stringifyWsseKey(this.computeWsseKey());
    }
};

module.exports = AuthenticationService;
