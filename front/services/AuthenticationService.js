var localStorageService = require('./LocalStorageService');
var _ = require('underscore');
var AUTHENTICATION_IDENTIFIER = "watch-auth";
var AuthenticationService = {
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
        var keys = {
            'public': public,
            'secret': secret
        }

        localStorageService.setValues(AUTHENTICATION_IDENTIFIER, keys);
    }
};

module.exports = AuthenticationService;
