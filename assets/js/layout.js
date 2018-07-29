'use strict';

import $ from 'jquery';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';
import '../css/pagination.css';
import 'select2/dist/css/select2.min.css'
import 'typeahead.js/dist/typeahead.jquery.min'
import 'typeahead.js/dist/typeahead.bundle'

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$('#exampleModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);     // Кнопка, что спровоцировало модальное окно
    let recipient = button.data('whatever'); // Извлечение информации из данных-* атрибутов
    let modal = $(this);
    modal.find('.modal-title').text('New message to ' + recipient);
    modal.find('.modal-body input').val(recipient)
});