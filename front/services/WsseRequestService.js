import AuthenticationService from './AuthenticationService';
import request from 'request';
import assign from 'object-assign';
import configuration from '../configuration';

var WsseRequestService = assign({}, {
    computeUrl: function(uri) {
        var url = 'http://'+configuration.get('backEndAddress');
        url += uri;

        return url;
    },
    request: function(options, callback) {
        var _options = assign({}, this._getRequestHeaders(), options);
        request(_options, callback);
    },
    get: function(options, callback) {
        var _options = assign({method: "GET"}, options);

        this.request(_options, callback);
    },
    post: function(options, callback) {
        var _options = assign({method: "POST"}, options);
        this.request(_options, callback);
    },
    put: function(options, callback) {
        var _options = assign({method: "PUT", options});
        this.request(_options, callback);
    },
    _getRequestHeaders: function() {
        return {
            headers: {
                "x-wsse": AuthenticationService.getWssePhrase(),
                "content-type": "application/json"
            }
        }
    }
});

module.exports = WsseRequestService;
