// Launch authentication

var AuthenticationService = require('./services/AuthenticationService');
if (
    !AuthenticationService.isAuthenticated()
    && !AuthenticationService.checkRequest()
) {
    AuthenticationService.auth();
} else {

    var lr = require('./storeRepositories/LinkRepository');
    lr.getAll();

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
