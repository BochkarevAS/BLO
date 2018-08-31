'use strict';

import $ from 'jquery';
import '../../../css/client/fileupload.css'
import 'blueimp-file-upload/js/vendor/jquery.ui.widget.js'
import 'blueimp-file-upload/js/jquery.iframe-transport.js'
import 'blueimp-file-upload/js/jquery.fileupload.js'
import 'blueimp-file-upload/js/jquery.fileupload-image.js'
import 'jquery-knob'

class Fileupload {

    constructor() {
        let ul = $('#fileupload ul');

        $('#drop a').click(function() {
            $(this).parent().find('input').click();
        });

        const obj  = {

            // Этот элемент будет принимать загрузку перетаскивания файлов
            dropZone: $('#drop'),

            // Функция помощника, которая форматирует размеры файлов
            formatFileSize(bytes) {
                const big     = 1000000000;
                const average = 1000000;
                const little  = 1000;

                if (typeof bytes !== 'number') {
                    return '';
                }

                if (bytes >= big) {
                    return (bytes / big).toFixed(2) + ' GB';
                }

                if (bytes >= average) {
                    return (bytes / average).toFixed(2) + ' MB';
                }

                return (bytes / little).toFixed(2) + ' KB';
            },
            add(e, data) {

                let template = `
                    <li class='working'>
                        <input type='text' value='0' data-width='48' data-height='48' data-fgColor='#0788a5' data-readOnly='1' data-bgColor='#3e4043'>
                     <p></p><span></span>
                    </li>`;

                let tpl = $(template);
                let file = data.files[0];
                let size = obj.formatFileSize(file.size);

                // Добавить имя файла и размер файла
                tpl.find('p').text(file.name).append('<i>' + size + '</i>');

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
            progress(e, data) {
                let progress = parseInt(data.loaded / data.total * 100, 10);

                // Обновление скрытого поля ввода и запуск изменения так что плагин jQuery knob знает, что обновить
                data.context.find('input').val(progress).change();

                if (progress === 100){
                    data.context.removeClass('working');
                }
            },
            fail(e, data) {
                data.context.addClass('error');
            }
        };

        $('#fileupload').fileupload(obj);
    }
}

export default Fileupload;