import dispatcher from '../dispatcher';
import events from 'events';
import assign from 'object-assign';
import tagRepository from '../storeRepositories/TagRepository';
import ActionTypes from '../constants/ActionTypes';

var EventEmitter = events.EventEmitter
var CHANGE_EVENT = "change";
var tags = [];

var TagService = assign({}, EventEmitter.prototype, {
    getTags: function() {
        return tags;
    },
    getTag: function(id) {
        return tags[id];
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

TagService.dispatcherToken = dispatcher.register(function(action) {
    switch(action.type) {
        case ActionTypes.RECEIVE_LINKS:
            action.tags.forEach(function(tag) {
                tags[tag.id] = tag;
            });
            TagService.emitChange();
            break;
        default:
    }
})

module.exports = TagService;
