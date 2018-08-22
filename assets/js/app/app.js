'use strict';

import $ from 'jquery';
import Model from '../Components/Parts/Model';
import Tyre from '../Components/Tyres/Tyre';
import Company from '../Components/Client/Company';
import Region from '../Components/Client/Region';

// import Part from "./Components/Parts/Part";

$(document).ready(function() {
    let $wrapper = $('.js-part-module');
    let model = new Model($wrapper);

    $wrapper = $('.js-company-module');
    let company = new Company($wrapper);

    $wrapper = $('.js-tyre-module');
    let tyre = new Tyre($wrapper);

    $wrapper = $('.js-user-module');
    let region = new Region($wrapper);

    // let part = new Part();
});