'use strict';

import $ from 'jquery';
import 'select2/dist/js/select2.min'

class Tyre {

    constructor() {
        $("#tyres_manufacturers").select2();

        $("#tyres_model").select2({
            closeOnSelect: false
        });

        $("#tyres_vendor").select2({
            closeOnSelect: false
        });
    }
}

export default Tyre;