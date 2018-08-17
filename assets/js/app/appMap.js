'use strict';

import $ from 'jquery';
import Maps from '../Components/Client/Maps'

$(document).ready(function() {
    let map = new Maps();
    map.initMap();
});