'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class News {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '.js-news-display',
            this.display.bind(this)
        );
    }

    display(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let id = $link.data('id');

        // $link.addClass('text-danger');
        // $link.find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');

        $.ajax({
            url: Routing.generate('news_display', {id: id}),
            method: 'POST'
        }).then(() => {

            console.log(new Date().getTime());
            // $row.fadeOut('normal', () => {
            //
            // });
        });
    }
}

export default News;