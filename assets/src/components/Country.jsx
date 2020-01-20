import $ from 'jquery'
import {get} from '../action/axios'

class Country {

    constructor($wrapper) {
        $wrapper.on('change', '#region', this.findDepartment.bind(this));
        $wrapper.on('change', '#department', this.findCity.bind(this));

        $('#region').selectpicker({
            countSelectedText: function(num) {
                return '{0}';
            },
            liveSearch: true,
            noneResultsText: 'результатов не найдено {0}',
            dropupAuto: true,
            selectedTextFormat: 'count',
            style: 'btn-light bs-placeholder',
            size: 7
        });

        $('#department').selectpicker({
            countSelectedText: function(num) {
                return '{0}';
            },
            liveSearch: true,
            noneResultsText: 'результатов не найдено {0}',
            dropupAuto: true,
            selectedTextFormat: 'count',
            style: 'btn-light bs-placeholder',
            size: 7
        });

        $('#city').selectpicker({
            countSelectedText: function(num) {
                return '{0}';
            },
            liveSearch: true,
            noneResultsText: 'результатов не найдено {0}',
            dropupAuto: true,
            selectedTextFormat: 'count',
            style: 'btn-light bs-placeholder',
            size: 7
        });
    }

    findDepartment(e) {
        e.preventDefault();

        let $field = $('#region');
        let target = '#department';

        let id = $field.val();

        if (id) {
            get(`/api/department/${id}/region`)
                .then((json) => {

                    let data = json.data;
                    let $select = $(target);

                    $($select).find('option').remove();

                    $($select).append($("<option/>").attr("value", '').text(''));

                    $(data).each(function (index, o) {
                        let $option = $("<option/>").attr("value", o.id).text(o.name);
                        $select.append($option);
                    });

                    $(target).replaceWith($select);
                    $(target).selectpicker('refresh');
                })
                .catch((err) => {
                    console.error('err', err);
                });
        }
    }

    findCity(e) {
        e.preventDefault();

        let $field = $('#department');
        let target = '#city';

        let id = $field.val();

        if (id) {
            get(`/api/department/${id}/city`)
                .then((json) => {

                    let data = json.data;
                    let $select = $(target);

                    $($select).find('option').remove();

                    $($select).append($("<option/>").attr("value", '').text(''));

                    $(data).each(function (index, o) {
                        let $option = $("<option/>").attr("value", o.id).text(o.name);
                        $select.append($option);
                    });

                    $(target).replaceWith($select);
                    $(target).selectpicker('refresh');
                })
                .catch((err) => {
                    console.error('err', err);
                });
        }
    }
}

export default Country;