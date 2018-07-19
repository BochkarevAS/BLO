'use strict';

import $ from 'jquery';

class Company {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '#company_create_phone',
            this.createPhone.bind(this)
        );

        this.$wrapper.on('click', 'js-company-delete',
            this.removePhone.bind(this)
        );
    }

    createPhone(e) {
        e.preventDefault();

        let id = $('.field').length ; console.log(111);
        let html = rowTemplate(id);

        $(html).fadeIn('slow').appendTo('.inputs');
    }

    removePhone(e) {
        e.preventDefault();

        let i = $('.field').length;

        if (i > 1) {
            $('.field:last').remove();
            i--;
        }
    }
}

const rowTemplate = (id) => `
    <div>
        <input id="field_${id}" type="text" class="field form-control col-3" name="dynamic[]">
        <a class="btn btn-primary ">Удалить</a>
    </div>`;

export default Company;