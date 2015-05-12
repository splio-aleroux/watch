/**
 * Routing directory of spliowatch application
 */

var React = require('react');
var Router = require('react-router');
var App = require('./app.jsx');
var CommentBox = require('./components/CommentBox.jsx');
var Route = Router.Route;
var DefaultRoute = Router.DefaultRoute;
var Routes = (
    <Route path="/" handler={App}>
        <Route name="coucou" handler={CommentBox} />
        <DefaultRoute handler={CommentBox} />
    </Route>
);

module.exports = Routes;