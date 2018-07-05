'use strict';

import $ from 'jquery';
import News from './Components/Administration/News';
import Model from './Components/Part/Model';
import Tyre from './Components/Tyres/Tyre';

$(document).ready(function() {
    let $wrapper = $('.js-news-module');
    let news = new News($wrapper);

    let model = new Model();
    model.changedModel();
    model.changedCarcase();

    let tyre = new Tyre();
});