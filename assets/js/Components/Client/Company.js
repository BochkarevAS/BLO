'use strict';

import $ from 'jquery';

class Company {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '.js-phone-new, .js-email-new',
            this.create.bind(this)
        );

        this.$wrapper.on('click', '.js-phone-delete, .js-email-delete',
            this.remove.bind(this)
        );
    }

    create(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let holder = $link.closest('.js-collection-holder');
        let prototype = holder.data('prototype');
        let index = holder.data('index');
        let newForm = prototype.replace(/__name__/g, index);

        holder.data('index', index + 1);
        $link.before(newForm);
    }

    remove(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        $link.closest('.js-holder-item').remove();
    }
}

export default Company;