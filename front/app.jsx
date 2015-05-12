var Router = require('react-router');
var React = require('react');

var RouteHandler = Router.RouteHandler;

var App = React.createClass({
	render: function() {
		return(<RouteHandler />);
	}
});

module.exports = App;