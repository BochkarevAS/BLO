'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Part {

    constructor() {

        let colors_suggestions = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.whitespace, // see its meaning above
            queryTokenizer: Bloodhound.tokenizers.whitespace, // see its meaning above
            local: ['Red','Blood Red','White','Blue','Yellow','Green','Black','Pink','Orange']
        });


        $('.typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                source: function (query, process) {
                    let $this = this;
                    $.ajax({
                        url: Routing.generate('parts_suggest'),
                        type: 'GET',
                        data: {
                            q: query,
                        },
                        success: function (data) {
                            let reversed = {};
                            let suggests = [];

                            $.each(data, function (id, elem) {
                                reversed[elem] = elem;
                                suggests.push(elem);
                            });
                            $this.reversed = reversed;

                            console.log(suggests);

                            process(suggests);
                        }
                    })
                },
                updater: function (item) {
                    let elem = this.reversed[item];

                    $('#zipcode').val(elem);

                    return elem;
                },
                matcher: function() {
                    return true;
                }
            });
    }
}

export default Part;