'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Model {

    changed() {
        $('#brand').change(function() {
            let val = $(this).val();

            $.ajax({
                url: Routing.generate('part_ajax_call', {part_id: val})
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
}

export default Model;

