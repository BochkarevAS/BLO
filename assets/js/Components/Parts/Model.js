'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Model {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#parts-brand, #parts-model',
            this.setRelation.bind(this)
        );

        $("#parts_brand").select2();
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#parts-brand');
        let target = '#' + $field.attr('id').replace('model', 'carcase').replace('brand', 'model');
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('part_index'),
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);

            if ('#parts-model' === target) {
                $('#parts-carcase').replaceWith('<select id="parts-carcase" name="brand[carcase]" class="form-control"></select>');
            }
        })
    }
}

export default Model;