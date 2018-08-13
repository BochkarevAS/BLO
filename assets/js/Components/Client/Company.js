'use strict';

import $ from 'jquery';

class Company {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '.js-item-new',
            this.create.bind(this)
        );

        this.$wrapper.on('click', '.js-item-remove',
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