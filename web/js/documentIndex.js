$(document).on('click', '.load-status', function (e) {
    e.preventDefault();
    var _this = $(this),
        url = _this.attr('href');
    status_selector = _this.data('target');
    status_element = $(document).find(status_selector);

    if (!status_element.length) {
        return true;
    }

    $.ajax({
        type: 'GET',
        url: url,
        success: function (response) {
            status_element.removeAttr('class');
            var text_block = status_element.children('b');
            text_block.text('');

            switch (response.state) {
                case 1:
                    status_element.addClass('formalized');
                    text_block.text('Оформление');
                    break;
                case 2:
                    status_element.addClass('sent');
                    text_block.text('Отправлено');
                    break;
                case 3:
                    status_element.addClass('delivered');
                    text_block.text('Доставлено');
                    break;
                case 4:
                    status_element.addClass('failure');
                    text_block.text('Отказ');
                    break;
            }
        },
        error: function () {
            alert("Ошибка загрузки данных")
        }
    });
});

$(document).on('click', '#updateAllBtn', function (e) {
    e.preventDefault();
    var checks = $(document).find('.form-check-input:checked');
    if (checks.length > 0) {
        $(checks).each(function () {
            var url = $(document).find($(this)).attr('href'),
                status_selector = $(document).find($(this)).data('target'),
                status_element = $(document).find(status_selector);

            $.ajax({
                type: 'GET',
                url: url,
                success: function (response) {
                    status_element.removeAttr('class');
                    var text_block = status_element.children('b');
                    text_block.text('');

                    switch (response.state) {
                        case 1:
                            status_element.addClass('formalized');
                            text_block.text('Оформление');
                            break;
                        case 2:
                            status_element.addClass('sent');
                            text_block.text('Отправлено');
                            break;
                        case 3:
                            status_element.addClass('delivered');
                            text_block.text('Доставлено');
                            break;
                        case 4:
                            status_element.addClass('failure');
                            text_block.text('Отказ');
                            break;
                    }
                },
                error: function () {
                    alert('Ошибка обновления данных');
                }
            });
        });
    }
});

$(document).on('click', '#deleteAllBtn', function (e) {
    e.preventDefault();
    var confirm = window.confirm('Удалить выбранные накладные?');
    if (confirm===true)
    {
        var checks = $(document).find('.form-check-input:checked');
        if (checks.length > 0) {
            var ids=[];
            $(checks).each(function () {
                ids.push($(this).attr('href').split('=')[1]);
            });

            $.ajax({
                type: "POST",
                url: '/document/massive-delete',
                data: {ids: ids}
            }).done(function () {
                alert('Накладные удалены удалены');
            })
        }
    }
});