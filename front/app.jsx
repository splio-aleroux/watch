var Router = require('react-router');
var React = require('react');

var routeHandler = Router.RouteHandler;

var App = React.createClass({
	render: function() {
		return(<routeHandler />);
	}
});

module.exports = App;