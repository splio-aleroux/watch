var dispatcher = require('./dispatcher');
var CommentBox = require('./components/CommentBox.jsx');
var React = require('react');

React.render(
  <CommentBox />,
  document.getElementById('content')
);