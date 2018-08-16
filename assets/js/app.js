'use strict';

import $ from 'jquery';
import Model from './Components/Parts/Model';
import Tyre from './Components/Tyres/Tyre';
import Company from './Components/Client/Company';

// import Part    from "./Components/Parts/Part";

$(document).ready(function() {
    let $wrapper = $('.js-parts-module');
    let model = new Model($wrapper);

    $wrapper = $('.js-company-module');
    let company = new Company($wrapper);

    $wrapper = $('.js-tyres-module');
    let tyre = new Tyre($wrapper);

    // let part = new Part();
});