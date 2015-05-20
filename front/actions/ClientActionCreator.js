import dispatcher from '../dispatcher';
import ActionTypes from '../constants/ActionTypes';

module.exports = {
    saveLink: function(link) {
        dispatcher.dispatch({
            type: ActionTypes.SAVE_LINK,
            link: link
        });
    }
}
