'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Tyre {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#tyres-brand',
            this.setRelation.bind(this)
        );

        $("#tyres-model").select2({
            closeOnSelect: false
        });
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#tyres-brand');
        let target = '#tyres-model';
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('tyres_index'),
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

export default Tyre;