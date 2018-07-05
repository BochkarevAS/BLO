'use strict';

import $ from 'jquery';
import 'select2/dist/js/select2.min'

class Tyre {

    constructor() {
        let $option = $("<option></option>").val("0").text("Все производители");
        let $option1 = $("<option></option>").val("0").text("Выбрать");
        let $option2 = $("<option></option>").val("0").text("Выбрать");

        $("#tyres_manufacturers").prepend($option).trigger('change').select2({
            placeholder: "Выберите производителя",
        });

        $("#tyres_model").select2({
            closeOnSelect: false
        });

        $("#tyres_vendor").select2({
            closeOnSelect: false
        });

        $("#tyres_thorn").prepend($option1).trigger('change');
        $("#tyres_seasonality").prepend($option2).trigger('change');
    }
}

export default Tyre;