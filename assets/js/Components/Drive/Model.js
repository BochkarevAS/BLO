'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Model {

    constructor($wrapper) {
        this.$wrapper = $wrapper;
        this.$wrapper.on('change', '#drive-brand', this.setRelation);
        this.$wrapper.on('change', '#drive-new-brand', this.setNewRelation);
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

    setNewRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#drive-new-brand');
        let target = '#drive-new-model';
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('drive_new'),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    }
}

export default Model;