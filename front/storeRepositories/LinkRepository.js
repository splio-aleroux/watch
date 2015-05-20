import RequestService from '../services/RequestService';
import assign from 'object-assign';
import ServerActionCreator from '../actions/ServerActionCreator';

var LINKS_URL = "/links/";
var CREATE_LINK_URL = "/links/"

var LinkRepository = assign({}, {
    getAll: function() {
        var options = {
            "url": RequestService.computeUrl(LINKS_URL)
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
    },
    save: function(link) {
        var options = {
            "url": RequestService.computeUrl(CREATE_LINK_URL)
        }

        RequestService.postWsse(options, function(error, message, response) {

        });
    }
});

module.exports = LinkRepository;
