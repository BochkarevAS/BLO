'use strict';

import $ from 'jquery'
import Routing from '../Routing'
import 'select2/dist/js/select2.min'

class Tyre {

    constructor($wrapper) {
        $wrapper.on('change', '#tyre-brand, #tyre-new-brand', this.setModelRelation);
    }

    setModelRelation(e) {
        let $brand = $(e.currentTarget);
        let id = $brand.closest('form').attr('id');
        let model = '#tyre-model';
        let path = 'tyre_index';
        let method = 'GET';
        let data = {};

        if ('tyre-form' !== id) {
            model = '#tyre-new-model';
            method = 'POST';
            path = 'tyre_new';
        }

        data[$brand.attr('name')] = $brand.val();

        $.ajax({
            url: Routing.generate(path),
            method: method,
            data: data
        }).then((data) => {
            let $input = $(data).find(model);
            $(model).replaceWith($input);
            $(model).select2({
                closeOnSelect: false
            });
        })
    }
}

export default Tyre;