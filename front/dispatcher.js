var flux = require('flux');
var objectAssign = require('object-assign');

var dispatcher = objectAssign(flux.Dispatcher, {
    test: function() {
        console.log("test");
    }
});

console.log(dispatcher);

module.exports = dispatcher;
