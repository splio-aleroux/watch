var React = require('react');
var LinkListItem = require('./LinkListItem');
var LinkService = require('../stores/LinkService');

var LinkSection = React.createClass({
    getInitialState: function() {
        return {
            links: LinkService.getLinks()
        }
    },
    componentDidMount: function() {
        LinkService.addChangeListener(this._onChange);
    },
    componentWillUnmount: function() {
        LinkService.removeChangeListener(this._onChange);
    },
    render: function() {
        var links = this.state.links.map(function(link) {
            return ( <LinkListItem link={link} /> );
        });

        return (
            <div className="row link-section">
                {links}
            </div>
        );
    },
    _onChange: function() {
        this.setState(LinkService.getLinks())
    }
});

module.exports = LinkSection;
