var RequestService = require('../services/RequestService');
var assign = require('object-assign');
var ServerActionCreator = require('../actions/ServerActionCreator');
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
