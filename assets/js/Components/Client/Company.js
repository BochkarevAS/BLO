'use strict';

import $ from 'jquery';

class Company {

    constructor() {

        this.$wrapper.on('click', '#company_add_phone',
            this.createPhone.bind(this)
        );


        let i = $('input').size() + 1;

        $('#remove').click(function() {
            if (i > 1) {
                $('.field:last').remove();
                i--;
            }
        });

        $('.submit').click(function(){
            let answers = [];

            $.each($('.field'), function() {
                answers.push($(this).val());
            });

            if (answers.length === 0) {
                answers = "none";
            }

            alert(answers);

            return false;
        });
    }


    createPhone(e) {
        let $link = $(e.currentTarget);
        let id = $link.data('id');


        console.log(id);

        $(e).click(function() {
            $('<div><input type="text" class="field" name="dynamic[]"></div>').fadeIn('slow').appendTo('.inputs');
            i++;
        });
    }
}

export default Company;