'use strict';

import $ from 'jquery';
import '../../../css/client/fileupload.css'
import 'blueimp-file-upload/js/jquery.fileupload'

class Fileupload {

    constructor() {
        let ul = $('#fileupload ul');

        $('#drop a').click(function() {
            $(this).parent().find('input').click();
        });
    }

    fileupload() {
        $('#fileupload').fileupload({

            // Этот элемент будет принимать загрузку перетаскивания файлов
            dropZone: $('#drop'),

            // Эта функция вызывается, когда файл добавляется в очередь,
            // либо с помощью кнопки обзора, либо с помощью перетаскивания:
            add: function (e, data) {

                let tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                    ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

                // Добавить имя файла и размер файла
                tpl.find('p').text(data.files[0].name)
                    .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

                // Добавьте HTML в элемент UL
                data.context = tpl.appendTo(ul);

                // Инициализировать плагин knob
                tpl.find('input').knob();

                // Прослушать клики на значке отмены
                tpl.find('span').click(function() {
                    if (tpl.hasClass('working')) {
                        jqXHR.abort();
                    }

                    tpl.fadeOut(function() {
                        tpl.remove();
                    });

                });

                // Автоматически загружать файл после его добавления в очередь
                let jqXHR = data.submit();
            },

            progress: function (e, data) {
                let progress = parseInt(data.loaded / data.total * 100, 10);

                // Обновление скрытого поля ввода и запуск изменения
                // так что плагин jQuery knob знает, что обновить
                data.context.find('input').val(progress).change();

                if (progress === 100){
                    data.context.removeClass('working');
                }
            },

            fail: function (e, data) {
                data.context.addClass('error');
            }
        });
    }

    // Функция помощника, которая форматирует размеры файлов
    formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }
}