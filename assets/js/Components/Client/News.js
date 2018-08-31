'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class News {

    constructor($wrapper) {
        this.$wrapper = $wrapper;

        this.$wrapper.on('click', '.js-news-display',
            this.display.bind(this)
        );

        this.$wrapper.on('click', '.js-news-display-on-main',
            this.displayOnMain.bind(this)
        );
    }

    displayOnMain(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let id = $link.data('id');

        $link.addClass('text-danger');
        $link = this._setClass($link);

        $.ajax({
            url: Routing.generate('news_display_on_main', {id: id}),
            method: 'POST'
        }).then(() => {
            $link.removeClass('text-danger');
        });
    }

    display(e) {
        e.preventDefault();

        let $link = $(e.currentTarget);
        let id = $link.data('id');

        $link.addClass('text-danger');
        $link = this._setClass($link);

        $.ajax({
            url: Routing.generate('news_display', {id: id}),
            method: 'POST'
        }).then(() => {
            $link.removeClass('text-danger');
        });
    }

    _setClass($link) {
        $link.addClass('text-danger');
        $link.find('.fa').toggleClass(function() {
            if ($(this).is('.fa-bell-slash')) {
                $(this).removeClass('fa-bell-slash');
                return 'fa-bell';
            } else {
                $(this).removeClass('fa-bell');
                return 'fa-bell-slash';
            }
        });

        return $link;
    }
}

export default News;