// Launch authentication
var LinkRepository = require('./storeRepositories/LinkRepository');
var AuthenticationService = require('./services/AuthenticationService');

if (!AuthenticationService.isAuthenticated()
    && !AuthenticationService.parseRequest()
) {
    AuthenticationService.authenticate();
} else {
    var Router = require('react-router');
    var Routes = require('./routes');
    var React = require('react');


    LinkRepository.getAll();
    Router.run(Routes, Router.HistoryLocation, function(Components) {
    	React.render(
    		<Components />,
    		document.getElementById('content')
    	);
    });
}
