var AuthenticationService = require('./AuthenticationService');
var request = require('request');
var assign = require('object-assign');

var RequestService = assign({}, {
    computeUrl: function(uri) {
        var url = window.location.protocol+'//';
        url += window.location.hostname;
        url += uri

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
