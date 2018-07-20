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

        let id = $('.field').length + 1;
        let html = rowTemplate(id);

        $(html).fadeIn('slow').appendTo('.inputs');
    }

    removePhone(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let $row = $link.closest('div');

        $row.remove();
    }
}

const rowTemplate = (id) => `
    <div class="row">
        <input id="field_${id}" type="text" class="field form-control col-3" name="dynamic[]">
        <a class="btn btn-primary js-phone-delete">Удалить</a>
    </div>`;

export default Company;