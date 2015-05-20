var React = require('react');
var TagListItem = require('./TagListItem');

var LinkListItem = React.createClass({
  render: function() {
    return (
        <div>
            <div className="col-md-12">
                <div className="col-md-2">
                    <span className="glyphicon glyphicon-heart-empty">42 reco</span>
                </div>
                <div className="col-md-8">
                    <a href={this.props.link.url}>{this.props.link.url}</a>
                </div>
            </div>
            <div className="col-md-12">
                <div className="col-md-2"><span className="glyphicon glyphicon-certificate">12 click</span></div>
                <div className="col-md-8">{this.props.link.createAt} - @penis - <TagListItem tags={this.props.link.tags.data} /></div>
            </div>
        </div>
    );
  }
});

module.exports = LinkListItem;
