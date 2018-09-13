'use strict';

import $ from 'jquery';
import Routing from "../Routing";

class User {

    constructor($wrapper) {
        $wrapper.on('click', '.js-add-favorite', this.addFavorite);
        $wrapper.on('click', '.js-remove-favorite', this.removeFavorite);
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
        }).then((data) => {
            $target.replaceWith(`<a href="#" class="js-remove-favorite" data-product='${ product }' data-type='${ type }'>Избранное удалить</a>`);
        });
    }

    removeFavorite(e) {
        e.preventDefault();

        let $target = $(e.currentTarget);
        let product = $target.data('product');
        let type = $target.data('type');

        $.ajax({
            url: Routing.generate('auth_user_remove_favorite', {'product': product, 'type': type}),
            method: 'POST',
            data: {}
        }).then((data) => {
            $target.replaceWith(`<a href="#" class="js-add-favorite" data-product='${ product }' data-type='${ type }'>Избранное</a>`);
        });
    }
}

export default User;