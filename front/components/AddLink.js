import React from 'react';
import Tags from './Tags';
import ClientActionCreator from '../actions/ClientActionCreator';

var AddLink = React.createClass({
    render: function() {
        return (
            <div className="container">
                <form className="form-signin" onSubmit={this.handleSubmit}>
                    <h2 className="form-signin-heading">Add link</h2>

                    <label htmlFor="inputUrl" className="sr-only">Url</label>
                    <input type="url" id="inputUrl" className="form-control" placeholder="http://your-wonderful-link.com" ref="url" />
                    <Tags ref="tags" />
                    <button className="btn btn-lg btn-primary btn-block" type="submit">Add</button>
                </form>
            </div>
        );
    },
    handleSubmit: function(event) {
        event.preventDefault();
        var link = {
            url:React.findDOMNode(this.refs.url).value.trim(),
            tags: React.findDOMNode(this.refs.tags).value.trim()
        };

        ClientActionCreator.saveLink(link)
    }
});

module.exports = AddLink;
