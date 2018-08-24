'use strict';

import $ from 'jquery';
import Fileupload from "../Components/Client/Fileupload";

// $(document).ready(function() {
//     let file = new Fileupload();
// });


$(document).on('drop dragover', function (e) {
    e.preventDefault();
    // let file = new Fileupload();
});