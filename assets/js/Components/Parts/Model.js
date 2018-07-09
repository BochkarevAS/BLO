'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Model {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#parts_brand, #parts_model',
            this.setRelation.bind(this)
        );
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#parts_brand');
        let target = '#' + $field.attr('id').replace('model', 'carcase').replace('brand', 'model');
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('parts_render'),
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);

            if ('#parts_model' === target) {
                $('#parts_carcase').replaceWith('<select id="parts_carcase" name="brand[carcase]" class="form-control"></select>');
            }
        })
    }
}

export default Model;

