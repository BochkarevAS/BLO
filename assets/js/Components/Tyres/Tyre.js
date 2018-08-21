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

        $("#tyres_model").select2({
            closeOnSelect: false
        });

        $("#tyres_vendor").select2({
            closeOnSelect: false
        });

        $("#tyres_brand").select2();
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#tyres_brand');
        let target = '#tyres-model';
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('tyres-index'),
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