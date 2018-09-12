'use strict';

import $ from 'jquery'
import Routing from '../Routing'
import 'select2/dist/js/select2.min'

class Drive {

    constructor($wrapper) {
        $wrapper.on('change', '#drive-brand, #drive-new-brand', this.setModelRelation);
    }

    setModelRelation(e) {
        let $brand = $(e.currentTarget);
        let id = $brand.closest('form').attr('id');
        let model = '#drive-model';
        let path = 'drive_index';
        let method = 'GET';
        let data = {};

        if ('drive-form' !== id) {
            model = '#drive-new-model';
            method = 'POST';
            path = 'drive_new';
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

export default Drive;