var dispatcher = require('../dispatcher');
var EventEmitter = require('events').EventEmitter;
var assign = require('object-assign');
var linkRepository = require('../storeRepositories/linkRepository');

var CHANGE_EVENT = "change";

var link = assign({}, EventEmitter.prototype, {
    getAll: function() {
        return {
            "size":123,
            "data":[
                {
                    "id":117022088,
                    "title": "Are you lost?",
                    "url":"http://perdu.com",
                    "tags":{
                        "size":3,
                        "data":[
                            {
                                "name":"js"
                            },
                            {
                                "name":"react"
                            },
                            {
                                "name":"flux"
                            }
                        ],
                        "_links":{
                            "timeline":{
                                "href":"http://perdu.com"
                            },
                            "statistics":{
                                "href":"http://perdu.com"
                            }
                        }
                    }
                },
                {
                    "id":526477409,
                    "title": "Ask Google!",
                    "url":"http://google.com",
                    "tags":{
                        "size":2,
                        "data":[
                            {
                                "name":"php"
                            },
                            {
                                "name":"rabbitmqueue"
                            }
                        ],
                        "_links":{
                            "timeline":{
                                "href":"http://perdu.com"
                            },
                            "statistics":{
                                "href":"http://perdu.com"
                            }
                        }
                    }
                },
                {
                    "id":812864697,
                    "title": "Hey sexy lady",
                    "url":"http://bonjourmadame.com",
                    "tags":{
                        "size":2,
                        "data":[
                            {
                                "name":"auth"
                            },
                            {
                                "name":"security"
                            }
                        ],
                        "_links":{
                            "timeline":{
                                "href":"http://perdu.com"
                            },
                            "statistics":{
                                "href":"http://perdu.com"
                            }
                        }
                    }
                }
            ],
            "_links":{
                "next":{
                    "href":"http://perdu.com"
                },
                "previous":{
                    "href":"http://perdu.com"
                },
                "last":{
                    "href":"http://perdu.com"
                },
                "first":{
                    "href":"http://perdu.com"
                }
            }
        };
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
