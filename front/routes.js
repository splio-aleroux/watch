/**
 * Routing directory of spliowatch application
 */

var React = require('react');
var Router = require('react-router');
var Route = Router.Route;
var DefaultRoute = Router.DefaultRoute;

var Routes = (
    <Route path="/" handler={require('./app.jsx')}>
        <DefaultRoute handler={require('./components/SplioWatch')} />
        <Route name="sign-in" path="/signin" handler={require('./components/SignIn')} />
        <Route name="sign-out" path="/signout" handler={require('./components/SignOut')} />
    </Route>
);

module.exports = Routes;
