'use strict';

import $ from 'jquery';

class Company {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '.js-phone-new',
            this.createPhone.bind(this)
        );

        this.$wrapper.on('click', '.js-phone-delete',
            this.removePhone.bind(this)
        );
    }

    createPhone(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let prototype = this.$wrapper.data('prototype');
        let index = this.$wrapper.data('index');
        let newForm = prototype.replace(/__name__/g, index);

        this.$wrapper.data('index', index + 1);
        $link.before(newForm);
    }

    removePhone(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        $link.closest('.js-phone-item').remove();
    }
}

export default Company;