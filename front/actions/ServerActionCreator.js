import dispatcher from '../dispatcher';
import ActionTypes from '../constants/ActionTypes';

module.exports = {
    getLinks: function(links) {
        dispatcher.dispatch({
            type: ActionTypes.RECEIVE_LINKS,
            links: links
        });
    },
    getTags: function(tags) {
        dispatcher.dispatch({
            type: ActionTypes.RECEIVE_TAGS,
            tags: tags
        });
    }
}
