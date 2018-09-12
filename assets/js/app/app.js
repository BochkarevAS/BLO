'use strict';

import $ from 'jquery'
import Part from '../Components/Part/Model'
import Company from '../Components/Client/Company'
import Region from '../Components/Client/Region'
import Drive from '../Components/Product/Drive'
import Tyre from '../Components/Product/Tyre'

// import Part from "./Components/Part/Part";

$(document).ready(function() {
    let $wrapper = $('.js-company-module');
    new Company($wrapper);

    $wrapper = $('.js-part-module');
    new Part($wrapper);

    $wrapper = $('.js-tyre-module');
    new Tyre($wrapper);

    $wrapper = $('.js-drive-module');
    new Drive($wrapper);

    $wrapper = $('.js-user-module');
    new Region($wrapper);

    // let part = new Part();
});