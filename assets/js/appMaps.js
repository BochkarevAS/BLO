'use strict';

import $ from 'jquery';
import Maps from './Components/Client/Maps'

$(document).ready(function() {
    let $wrapper = $('.js-tyres-show-module');
    let map = new Maps($wrapper);
    map.initMap();
});