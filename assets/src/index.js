import $ from 'jquery'
import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-select/dist/js/bootstrap-select'
import 'bootstrap-select/dist/css/bootstrap-select.min.css'
import 'selectric/src/jquery.selectric'
import Country from './components/Country'

window.jQuery = $;

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-tooltip="tooltip"]').tooltip();

    let $wrapper = $('.js-country-module');
    new Country($wrapper);
});