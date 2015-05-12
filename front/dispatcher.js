var Flux = require('flux');
var ObjectAssign = require('object-assign');

var Dispatcher = ObjectAssign(Flux.Dispatcher, {
    test: function() {
        console.log("test");
    }
});

module.exports = Dispatcher;
