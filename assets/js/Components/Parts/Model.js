'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Model {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#part-brand, #part-model',
            this.setRelation.bind(this)
        );

        $("#parts_brand").select2();
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#part-brand');
        let target = '#' + $field.attr('id').replace('model', 'carcase').replace('brand', 'model');
        let data = {}; console.log(111);

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('part_index'),
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);

            if ('#part-model' === target) {
                $('#part-carcase').replaceWith('<select id="part-carcase" name="brand[carcase]" class="form-control"></select>');
            }
        })
    }
}

export default Model;