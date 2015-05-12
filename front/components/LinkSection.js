var React = require('react');
var LinkListItem = require('./LinkListItem');
// var LinkStore = require('../stores/Link');

function getListLinkItem() {
	return (
		<LinkListItem />
	);
}


var LinkSection = React.createClass({
  render: function() {
  	var test = getListLinkItem();
    return (
      <div className="link-section">
        <ul className="link-list">
        	{test}
        </ul>
      </div>
    );
  }
});

module.exports = LinkSection;