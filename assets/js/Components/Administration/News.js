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
        let displayUrl = $link.data('url');
        let id = $link.data('id');

        $link.addClass('text-danger');
        $link.find('.fa').removeClass('fa-trash').addClass('fa-spinner').addClass('fa-spin');


        console.log(Routing);

        $.ajax({
            url: Routing.generate('news_display', {id: id}),
            // url: displayUrl,
            method: 'POST'
        }).then(() => {

            console.log(111);
            // $row.fadeOut('normal', () => {
            //
            // });
        });

        // console.log(displayUrl);

        // $.ajax({
        //
        // });

    }
}

export default News;