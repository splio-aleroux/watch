var React = require('react');
var LinkSection = require('./LinkSection');

var SplioWatch = React.createClass({
  render: function() {
    return (
    	<div id="link-container">
        	<LinkSection />
        </div>
    );
  }
});

module.exports = SplioWatch;
