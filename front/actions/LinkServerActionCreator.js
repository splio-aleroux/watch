var dispatcher = require('../dispatcher');
var ActionTypes = require('../constants/ActionTypes.js');

module.exports = {
    getLinks: function(links) {
        dispatcher.dispatch({
            type: ActionTypes.RECEIVE_LINKS,
            links: links
        });
    }
}
