import RequestService from '../services/WsseRequestService';
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
        RequestService.get(options, function(error, message, response) {
            if (null !== error) {
                ServerActionCreator.dispatchError(error);
            }
            links = JSON.parse(response).data;
            ServerActionCreator.getLinks(links);
        });

        return links;
    },
    save: function(link) {
        console.log(link);
        var options = {
            url: RequestService.computeUrl(CREATE_LINK_URL),
            json: link
        }

        RequestService.post(options, function(error, message, response) {
            if (message.statusCode === 201) {
                // The link has been created
                window.location.href = window.location.origin;
            } else {
                // Handle error
            }
        });
    }
});

module.exports = LinkRepository;
