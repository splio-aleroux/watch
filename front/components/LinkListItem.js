var React = require('react');

var LinkListItem = React.createClass({
  render: function() {
    return (
        <li>
            url: <a href={this.props.url}>{this.props.url}</a><br />
            created: {this.props.createAt}
        </li>
    );
  }
});

module.exports = LinkListItem;
