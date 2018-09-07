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
        e.preventDefault();

        let $regionField = $('#user-region');
        let $target = $('#data-user-id');
        let userId = $target.data('id');
        let target = '#user-city';
        let data = {};

        data[$regionField.attr('name')] = $regionField.val();

        $.ajax({
            url: Routing.generate('auth_profile_edit', {id: userId}),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        });
    }
}

export default Region;