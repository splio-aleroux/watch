var assign = require('object-assign');
var configuration = assign({}, {
    conf: {
        backEndAddress: 'app.box.local',
    },

    getConfiguration: function() {
        return this.conf
    },

    get: function(key) {
        return this.conf[key];
    }
});

module.exports = configuration;
