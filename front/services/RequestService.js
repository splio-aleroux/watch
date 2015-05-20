import AuthenticationService from './AuthenticationService';
import request from 'request';
import assign from 'object-assign';
import configuration from '../configuration';

var RequestService = assign({}, {
    computeUrl: function(uri) {
        var url = 'http://'+configuration.get('backEndAddress');
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
    },
    getWsse: function(options, callback) {
        var _options = assign({method: "POST"}, options);

        this.requestWsse(_options, callback);
    },
    postWsse: function(options, callback) {
        var _options = assign({method: "POST"}, options)
        this.requestWsse(_options, callback);
    }
});

module.exports = RequestService;
