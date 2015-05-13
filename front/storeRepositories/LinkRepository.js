var RequestService = require('../services/RequestService');
var assign = require('object-assign');
var LinkServerActionCreator = require('../actions/LinkServerActionCreator');
var LINK_URL = "/links";

var LinkRepository = assign({}, {
    getAll: function() {
        var options = {
            "url": RequestService.computeUrl(LINK_URL)
        };

        var links = [];
        RequestService.requestWsse(options, function(error, message, response) {
            if (null !== error) {
                LinkServerActionCreator.dispatchError(error);
            }
            links = JSON.parse(response).data;
            LinkServerActionCreator.getLinks(links);
        });

        return links;
    }
});

module.exports = LinkRepository;
