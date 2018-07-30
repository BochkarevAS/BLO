'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import Bloodhound from 'bloodhound-js';
import Handlebars from 'handlebars/dist/handlebars.min';

class Part {

    constructor() {

        let parts = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace,
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            remote: {
                url: Routing.generate('parts_suggest', {query: 'WILDCARD'}),
                wildcard: 'WILDCARD'
            }
        });

        $('.typeahead').typeahead({
            hint: true,
            highlight: true,
            minLength: 2
        }, {
            source: parts
        });
    }
}

export default Part;