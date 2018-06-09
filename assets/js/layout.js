'use strict';

import $ from 'jquery';
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.css';
import 'font-awesome/css/font-awesome.css';
import '../css/popup.css';

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});

$('#exampleModal').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget); // Кнопка, что спровоцировало модальное окно
    let recipient = button.data('whatever'); // Извлечение информации из данных-* атрибутов
    let modal = $(this);
    modal.find('.modal-title').text('New message to ' + recipient);
    modal.find('.modal-body input').val(recipient)
});