'use strict';

import $ from 'jquery';
import Maps from './Components/Client/Maps'

$(document).ready(function() {
    let map = new Maps("new york city");
    map.initMap();
});