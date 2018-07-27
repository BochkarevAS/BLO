'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Part {

    constructor() {

        $('.typeahead').typeahead('destroy');

        // $('#city1').typeahead({
        //     minLength: 3,
        //
        //     source: function(query, process) { console.log(111);
        //         let $this = this;
        //         $.ajax({
        //             url: Routing.generate('parts_suggest'),
        //             type: 'GET',
        //             data: {
        //                 q: query,
        //             },
        //             success: function(data) {
        //                 let reversed = {};
        //                 let suggests = [];
        //
        //                 $.each(data, function(id, elem) {
        //                     reversed[elem.suggest] = elem;
        //                     suggests.push(elem.suggest);
        //                 });
        //                 $this.reversed = reversed;
        //                 process(suggests);
        //             }
        //         })
        //     },
        //     updater: function(item) {
        //         let elem = this.reversed[item];
        //
        //         $('#zipcode').val(elem.zipcode);
        //
        //         return elem.city;
        //     },
        //
        //     matcher: function() {
        //         return true;
        //     }
        // });

        let $search = $('.search');

        $search.select2({
            theme: 'bootstrap',
            placeholder: 'Type to search',

            ajax : {
                url: Routing.generate('parts_suggest'),
                type: 'GET',
                data: function (params) {
                    return {
                        q: params.term
                    }
                },
                success: function(data) {
                    let reversed = {};
                    let suggests = [];

                    $.each(data, function(id, elem) {
                        reversed[elem.suggest] = elem;
                        suggests.push(elem.suggest);
                    });
                    // $this.reversed = reversed;
                    // process(suggests);
                }
            },


            // ajax: {
            //     url: Routing.generate('parts_suggest'),
            //     dataType: 'json',
            //     delay: 250,
            //     data: function (params) {
            //         return {
            //             q: params.term
            //         }
            //     },
            //     processResults: function (data, params) {
            //         return {
            //             results: data.suggestions
            //         }
            //     }
            // },

            cache: true,
            minimumInputLength: 1
        });

        // $search.on('select2:select', function (e) {
        //     window.location.href = Routing.generate('show_restaurant_redirect', {id: e.params.data.id});
        // });
    }
}

export default Part;