var dispatcher = require('../dispatcher');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var linkRepository = require('../storeRepositories/linkRepository');

var CHANGE_EVENT = "change";

var link = assign({}, EventEmitter.prototype, {
    getAll: function() {
        linkRepository.getAll();
    },
    emitChange: function() {
        this.emit(CHANGE_EVENT)
    },
    addChangeListener: function(callback) {
        this.addListener(CHANGE_EVENT, callback);
    },
    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },
    dispatcherIndex: dispatcher.register(function(payload) {
        var action = payload.action;
    })
});

module.exports = link;
