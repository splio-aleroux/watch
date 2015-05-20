import dispatcher from '../dispatcher';
import events from 'events';
import assign from 'object-assign';
import linkRepository from '../storeRepositories/LinkRepository';
import ActionTypes from '../constants/ActionTypes';

var EventEmitter = events.EventEmitter;
var CHANGE_EVENT = "change";
var links = [];

var LinkService = assign({}, EventEmitter.prototype, {
    getLinks: function() {
        return links;
    },
    getLink: function(id) {
        return links[id];
    },
    emitChange: function() {
        this.emit(CHANGE_EVENT)
    },
    addChangeListener: function(callback) {
        this.addListener(CHANGE_EVENT, callback);
    },
    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }
});

LinkService.dispatcherToken = dispatcher.register(function(action) {
    switch(action.type) {
        case ActionTypes.RECEIVE_LINKS:
            action.links.forEach(function(link) {
                links[link.id] = link;
            });
            LinkService.emitChange();
            break;
        default:
    }
})

module.exports = LinkService;
