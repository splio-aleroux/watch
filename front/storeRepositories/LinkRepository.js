var RequestService = require('../services/RequestService');
var assign = require('object-assign');
var LINK_URL = "/links";

var LinkRepository = assign({}, {
    getAll: function() {
        var options = {
            "url": LINK_URL
        };
        var links = [];
        RequestService.requestWsse(options, function(results) {
            links = results;
        });

        console.log(links);
    }
});

module.exports = LinkRepository;
