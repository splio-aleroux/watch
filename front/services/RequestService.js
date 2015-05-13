var AuthenticationService = require('./AuthenticationService');
var request = require('request');
var assign = require('object-assign');
var configuration = require('../configuration');

var RequestService = assign({}, {
    computeUrl: function(uri) {
        url = 'http://'+configuration.get('backEndAddress');
        url += uri;

        return url;
    },
    requestWsse: function(options, callback) {
        var _options = assign({}, options, {
            "headers": {
                "X-WSSE": AuthenticationService.getWssePhrase()
            }
        });

        request(_options, callback);
    }
});

module.exports = RequestService;
