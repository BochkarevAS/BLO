'use strict';

import $ from 'jquery';
import 'select2/dist/js/select2.min'

class Tyre {

    constructor() {
        $("#tyres_brands").select2();

        $("#tyres_models").select2({
            closeOnSelect: false
        });

        $("#tyres_vendors").select2({
            closeOnSelect: false
        });
    }
}

export default Tyre;