var React = require('react');

var LinkListItem = React.createClass({
  render: function() {
    return (
        <div>
            <div className="col-md-12">
                <div className="col-md-2">
                    <span className="glyphicon glyphicon-heart-empty">42 reco</span>
                </div>
                <div className="col-md-8">
                    <a href={this.props.url}>{this.props.url}</a>
                </div>
            </div>
            <div className="col-md-12">
                <div className="col-md-2"><span className="glyphicon glyphicon-certificate">12 click</span></div>
                <div className="col-md-8">{this.props.createAt} - @penis - #tag1 #tag2 #tag3 #tag4</div>
            </div>
        </div>
    );
  }
});

module.exports = LinkListItem;
