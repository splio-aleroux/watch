var RequestService = require('../services/RequestService');
var assign = require('object-assign');
var ServerActionCreator = require('../actions/ServerActionCreator');
var TAG_URL = "/tags/";

var TagRepository = assign({}, {
    getAll: function() {
        var options = {
            "url": RequestService.computeUrl(TAG_URL)
        };

        var tags = [];
        RequestService.requestWsse(options, function(error, message, response) {
            if (null !== error) {
                ServerActionCreator.dispatchError(error);
            }
            tags = JSON.parse(response).data;
            ServerActionCreator.getTags(tags);
        });

        return tags;
    }
});

module.exports = TagRepository;
