'use strict';

import $ from 'jquery';
import Routing from '../Routing';
import 'select2/dist/js/select2.min'

class Tyre {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#tyre-brand',
            this.setRelation.bind(this)
        );

        this.$wrapper.on('change', '#tyre-new-brand',
            this.setNewRelation.bind(this)
        );
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#tyre-brand');
        let target = '#tyre-model';
        let data = {};

        $("#tyre-model").select2({
            closeOnSelect: false
        });

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('tyre_index'),
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
        let $brandField = $('#tyre-new-brand');
        let target = '#tyre-new-model';
        let data = {};

        data[$brandField.attr('name')] = $brandField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('tyre_new'),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    }
}

export default Tyre;