'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Region {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('change', '#user-region',
            this.setRelation.bind(this)
        );
    }

    setRelation(e) {
        let $field = $(e.currentTarget);
        let $regionField = $('#user-region');
        let $target = $('#data-user-id');
        let userId = $target.data('id');
        let target = '#user-city';
        let data = {};

        data[$regionField.attr('name')] = $regionField.val();
        data[$field.attr('name')] = $field.val();

        $.ajax({
            url: Routing.generate('client_user_edit', {id: userId}),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        })
    }
}

export default Region;