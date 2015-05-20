import React from 'react';

var TagListItem = React.createClass({
  render: function() {
        var tags = this.props.tags.map(function(tag) {
            var tagUrl = "tags/"+tag.id;
            return <a href={tagUrl}>{tag.name}</a>;
        });
        return (
            <span>{tags}</span>
        );
    }
});

module.exports = TagListItem;
