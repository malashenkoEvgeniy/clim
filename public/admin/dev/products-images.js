$(document).ready(function () {
    // Генерируем случайный UID
    function guid() {
        function s4() {
            return Math.floor((1 + Math.random()) * 0x10000)
                .toString(16)
                .substring(1);
        }
        return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
            s4() + '-' + s4() + s4() + s4();
    }
    // Объект, сохраняющий в себе изображения для отправки на сервер
    var fFilesObject = {};
    // Кликаем по кнопке добавления новых изображений
    $('body').on('click', '.custom-uploader .add-images', function () {
        $(this).closest('.custom-uploader-images-block').find('input[type="file"]').click();
    });
    // Обрабатываем добавление новых изображений
    $('body').on('change', '.custom-uploader input[type="file"]', function () {
        var $it = $(this), files = this.files, file, i, maxSize = 10 * 1024 * 1024, showError = false;
        for (i in files) {
            file = files[i];
            if (!file.size) {
                continue;
            }
            if (file.size > maxSize) {
                showError = true;
                continue;
            }
            var regex = /^image\/(.*)$/;
            if (!regex.exec(file.type)) {
                showError = true;
                continue;
            }
            file.id = guid();
            fFilesObject[file.id] = file;
            $('body').find('.custom-uploader .custom-uploader-images-list').append('<li data-id="' + file.id + '" style=\'background-image: url("' + URL.createObjectURL(file) + '");\'><button class="button-round attachments-item__button"><i class="fa fa-close"></i></button></li>');
        }
        $it.after('<input type="file" name="files[]" accept=".jpg, .png, .bmp, .gif" multiple />');
        $it.remove();
        if (showError === true) {
            message('Загрузить можно только изображения до 10 Мб!', 'error');
        }
    });
    // Удаляем изображение из списка загружаемых
    $('body').on('click', '.custom-uploader .button-round', function () {
        var it = $(this), li = it.closest('li'), uid = li.data('id');
        li.remove();
        delete fFilesObject[uid];
    });
    // Отправляем картинки на сервер
    $('body').on('click', '.custom-uploader .submit-ajax-form', function () {
        var it = $(this), uploader = it.closest('.custom-uploader'), data = new FormData(), i;
        if (it.hasClass('disabled')) {
            return false;
        }
        for (i in fFilesObject) {
            data.append(i, fFilesObject[i]);
        }
        $.ajax({
            url: uploader.data('upload-url'),
            type: 'POST',
            dataType: 'JSON',
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                it.after('<div class="progress active time-to-time-loader" style="width: ' + (it.width() + 25) + 'px;">' +
                    '<div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">' +
                    '</div>' +
                    '</div>');
                it.addClass('disabled').hide();
            }
        }).done(function (data) {
            if (data.images) {
                $('#for-images-block').html(data.images);
                setTimeout(function () {
                    initImagesSortable();
                }, 250);
            }
            if (data.jQuery) {
                wAjax.start(data.jQuery);
            }
        }).fail(function () {
            message('Ошибка сервера. Пожалуйста, обновите страницу и попробуйте еще раз', 'error');
        }).always(function () {
            $.magnificPopup.close();
        });
        return false;
    });

    initImagesSortable();
});