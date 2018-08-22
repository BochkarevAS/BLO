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
            this.setRelation.bind(this)
        );

        $("#tyre-model").select2({
            closeOnSelect: false
        });
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $brandField = $('#tyre-brand');
        let target = '#tyre-model';
        let data = {};

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
}

export default Tyre;