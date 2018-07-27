'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Model {

    constructor() {
        let $search = $('.search');

        $search.select2({
            theme: 'bootstrap',
            placeholder: 'Type to search',
            ajax: {
                url: Routing.generate('parts_suggest'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function (data, params) {
                    return {
                        results: data.suggestions
                    }
                }
            },
            cache: true,
            minimumInputLength: 1
        });

        // $search.on('select2:select', function (e) {
        //     window.location.href = Routing.generate('show_restaurant_redirect', {id: e.params.data.id});
        // });
    }
}

export default Part;