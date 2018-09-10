'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Region {

    constructor($wrapper) {
        $wrapper.on('change', '#user-region', this.setRelation);
    }

    setRelation(e) {
        e.preventDefault();

        let $regionField = $('#user-region');
        let target = '#user-city';
        let data = {};

        data[$regionField.attr('name')] = $regionField.val();

        $.ajax({
            url: Routing.generate('auth_profile_edit'),
            method: 'POST',
            data: data
        }).then((data) => {
            let $input = $(data).find(target);
            $(target).replaceWith($input);
        });
    }
}

export default Region;