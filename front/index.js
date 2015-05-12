var Router = require('react-router');
var Routes = require('./routes');
var React = require('react');

Router.run(Routes, Router.HistoryLocation, function(Components) {
	React.render(
		<Components />,
		document.getElementById('content')
	);
});