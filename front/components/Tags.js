import React from 'react';

var Tags = React.createClass({
    render: function() {
        return (
            <input type="text" id="inputTags" className="form-control" placeholder="tags" />
        )
    }
});

module.exports = Tags;
