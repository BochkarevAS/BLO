'use strict';

import $ from 'jquery';
import News from './Components/Administration/News';
import Model from './Components/Parts/Model';
import Tyre from './Components/Tyres/Tyre';
import Company from "./Components/Client/Company";

$(document).ready(function() {
    let $wrapper = $('.js-news-module');
    let news = new News($wrapper);

    $wrapper = $('.js-parts-module');
    let model = new Model($wrapper);

    let tyre = new Tyre();

    $wrapper = $('.js-company-module');
    let company = new Company($wrapper);
});