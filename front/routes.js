/**
 * Routing directory of spliowatch application
 */

var React = require('react');
var Router = require('react-router');
var Route = Router.Route;
var DefaultRoute = Router.DefaultRoute;

var Routes = (
    <Route path="/" handler={require('./app.jsx')}>
        <DefaultRoute handler={require('./components/CommentBox.js')} />
        <Route name="sign-in" path="/signin" handler={require('./components/SignIn.js')} />
        <Route name="sign-out" path="/signout" handler={require('./components/SignOut.js')} />
    </Route>
);

module.exports = Routes;