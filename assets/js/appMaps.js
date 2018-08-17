'use strict';

import $ from 'jquery';
import Maps from './Components/Client/Maps'
import '@fancyapps/fancybox/dist/jquery.fancybox.min.css';
import '@fancyapps/fancybox/dist/jquery.fancybox.min';

$(document).ready(function() {
    let map = new Maps();
    map.initMap();

    $('[data-fancybox]').fancybox({})
});