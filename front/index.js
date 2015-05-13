// Launch authentication

var AuthenticationService = require('./services/AuthenticationService');
if (
    !AuthenticationService.isAuthenticated()
    && !AuthenticationService.parseRequest()
) {
    AuthenticationService.authenticate();
} else {
    var ls = require('./stores/LinkService');
    ls.getLinks();

    var Router = require('react-router');
    var Routes = require('./routes');
    var React = require('react');

    Router.run(Routes, Router.HistoryLocation, function(Components) {
    	React.render(
    		<Components />,
    		document.getElementById('content')
    	);
    });
}
