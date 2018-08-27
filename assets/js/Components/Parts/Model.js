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

        this.$wrapper.on('change', '#part-new-brand, #part-new-model',
            this.setNewRelation.bind(this)
        );
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#part-brand');
        let target = '#' + $field.attr('id').replace('part-model', 'part-carcase').replace('part-brand', 'part-model');
        let data = {};

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

    setNewRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#part-new-brand');
        let target = '#' + $field.attr('id').replace('part-new-model', 'part-new-carcase').replace('part-new-brand', 'part-new-model');
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('part_new'),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);

            if ('#part-new-model' === target) {
                $('#part-new-carcase').replaceWith('<select id="part-new-carcase" name="brand[carcase]" class="form-control"></select>');
            }
        })
    }
}

export default Model;