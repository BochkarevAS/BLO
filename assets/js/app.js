'use strict';

import $ from 'jquery';
import News from './Components/Administration/News';

$(document).ready(function() {
    let $wrapper = $('.js-news-module');
    let news = new News($wrapper);

    console.log(new Date().getTime());
});