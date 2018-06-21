'use strict';

import $ from 'jquery';
import Routing from '../Routing';

class Model {

    changed() {
        // let $sport = $('#test');
        //
        // $sport.change(function() {
        //     console.log($sport);
        //     let $form = $(this).closest('form');
        //     let data = {};
        //     data[$sport.attr('name')] = $sport.val();
        //
        //     $.ajax({
        //         url : $form.attr('action'),
        //         type: $form.attr('method'),
        //         data : data,
        //         success: function (html) {
        //             $('#test1').replaceWith(
        //                 $(html).find('#test1')
        //             );
        //         }
        //     });
        // });

        $('#test').change(function() {
            let val = $(this).val();

            $.ajax({
                url: Routing.generate('part_ajax_call', {part_id: val})
            }).then((data) => {
                $('#test1').html('');
                $.each(data, function(k, v) {
                    $('#test1').append('<option value="' + v + '">' + k + '</option>');
                });
            }).catch(jqXHR => {
                let errorData = JSON.parse(jqXHR.responseText);
            });

            return false;
        });
    }
}

export default Model;

