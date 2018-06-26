'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Model {

    changedModel() {
        $('#brand').change(function() {
            let id = $(this).val();

            $.ajax({
                url: Routing.generate('part_ajax', {model_id: id})
            }).then((data) => {
                $('#model').html('');
                $.each(data, function(k, v) {
                    $('#model').append('<option value="' + v + '">' + k + '</option>');
                });
            }).catch(jqXHR => {
                let errorData = JSON.parse(jqXHR.responseText);
            });

            return false;
        });
    }

    changedCarcase() {
        $('#model').change(function() {
            let id = $(this).val();

            $.ajax({
                url: Routing.generate('part_ajax', {carcase_id: id})
            }).then((data) => {
                $('#carcase').html('');
                $.each(data, function(k, v) {
                    $('#carcase').append('<option value="' + v + '">' + k + '</option>');
                });
            }).catch(jqXHR => {
                let errorData = JSON.parse(jqXHR.responseText);
            });

            return false;
        });
    }
}

export default Model;

