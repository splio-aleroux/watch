var AuthenticationService = require('./AuthenticationService');
var assign = require('object-assign');

var RequestService = assign({}, {
    requestWsse: function(options, callback) {
        var _options = assign({}, options, {
            "headers": {
                "X-WSSE": AuthenticationService.getWssePhrase()
            }
        });
        request(_options, callback);
    }
});

module.exports = AuthenticationService;
