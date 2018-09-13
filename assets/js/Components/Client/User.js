'use strict';

import $ from 'jquery';
import Routing from "../Routing";

class User {

    constructor($wrapper) {
        $wrapper.on('click', '.js-favorite', this.addFavorite);
    }

    addFavorite(e) {
        e.preventDefault();

        let $target = $(e.currentTarget);
        let product = $target.data('product');
        let type = $target.data('type');

        $.ajax({
            url: Routing.generate('auth_user_add_favorite', {'product': product, 'type': type}),
            method: 'POST',
            data: {}
        }).then((data) => {});
    }

}

export default User;