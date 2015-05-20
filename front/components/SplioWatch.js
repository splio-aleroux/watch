import React from 'react';
import LinkSection from './LinkSection';
import LinkRepository from '../storeRepositories/LinkRepository';

var SplioWatch = React.createClass({
    render: function() {
        LinkRepository.getAll();
        return (
            <div id="link-container">
                <LinkSection />
            </div>
        );
    }
});

module.exports = SplioWatch;
