'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Model {

    constructor($wrapper) {
        this.$wrapper = $wrapper;
        this.$wrapper.on('change', '#drive-brand', this.setRelation);
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#drive-brand');
        let target = '#drive-model';
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('drive_index'),
            method: 'GET',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
            $(target).select2({
                closeOnSelect: false
            });
        })
    }
}

export default Model;