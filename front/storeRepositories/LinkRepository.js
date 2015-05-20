import RequestService from '../services/RequestService';
import assign from 'object-assign';
import ServerActionCreator from '../actions/ServerActionCreator';
var LINK_URL = "/links/";

var LinkRepository = assign({}, {
    getAll: function() {
        var options = {
            "url": RequestService.computeUrl(LINK_URL)
        };

        var links = [];
        RequestService.requestWsse(options, function(error, message, response) {
            if (null !== error) {
                ServerActionCreator.dispatchError(error);
            }
            links = JSON.parse(response).data;
            ServerActionCreator.getLinks(links);
        });

        return links;
    }
});

module.exports = LinkRepository;
