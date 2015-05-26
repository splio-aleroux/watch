/**
 * Routing directory of spliowatch application
 */

import React from 'react';
import Router from 'react-router';
import App from './app.jsx';
import SplioWatch from './components/SplioWatch';
import AddLink from './components/AddLink';
import SignIn from './components/SignIn';
import SignOut from './components/SignOut';

var Route = Router.Route;
var DefaultRoute = Router.DefaultRoute;

var Routes = (
    <Route path="/" handler={App}>
        <DefaultRoute handler={SplioWatch} />
        <Route name="sign-in" path="/signin" handler={SignIn} />
        <Route name="sign-out" path="/signout" handler={SignOut} />
        <Route name="add" path="/add" handler={AddLink} />
    </Route>
);

module.exports = Routes;
