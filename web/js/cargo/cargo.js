$(document).ready(function () {

    var addPlace = $('#addPlace');
    var cargo_list = $('.cargo-list');
    var cargo_type = $('.cargo-element-type');
    var posts = 0;

    /**
     *
     *  Переменные полей сделал глобальными в блоке
     */

    var sendWeight=$('#sendWeight');
    var sizes=$('.sizes');
    var weight_input= $('.cargo-element-weight');
    var length_input= $('.cargo-element-length');
    var width_input= $('.cargo-element-width');
    var height_input= $('.cargo-element-height');
    var overweight=$('.overweight');

    /**
     *  При наведении курсора на слайдер изменения будут применяться только к полям в родительском блоке
     */

    $(document).on('mouseenter', '#sliderSlider', function () {
        var element=$(this).closest('#cargoElement');
        sendWeight=element.find('#sendWeight');
        sizes=element.find('.sizes');
        weight_input=element.find('.cargo-element-weight');
        length_input=element.find('.cargo-element-length');
        width_input=element.find('.cargo-element-width');
        height_input=element.find('.cargo-element-height');
        overweight=element.find('.overweight');
        console.log(sendWeight);
        console.log(sizes);
        console.log(weight_input);
        console.log(length_input);
        console.log(width_input);
        console.log(height_input);
        console.log(overweight);
    });

    var slider_settings = {
        "id": "sliderSlider",
        "value": 1,
        "min": 1,
        "max": 8,
        "step": 1,
        "reserved": true,
        "ticks": [1, 2, 3, 4, 5, 6, 7, 8],
        "formatter": function (val) {
            switch (val)
            {
                case 1:
                {
                    sendWeight.text('до 0.5 кг');
                    sizes.text('15x12x11');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('0.5');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '0.5';
                }
                    break;
                case 2:
                {
                    sendWeight.text('до 1 кг');
                    sizes.text('26x14x11');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('1');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '1';
                }
                    break;
                case 3:
                {
                    sendWeight.text('до 2 кг');
                    sizes.text('33x22x11');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('2');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '2';
                }
                    break;
                case 4:
                {
                    sendWeight.text('до 5 кг');
                    sizes.text('40x25x20');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('5');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '5';
                }
                    break;
                case 5:
                {
                    sendWeight.text('до 10 кг');
                    sizes.text('42x34x28');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('10');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '10';
                }
                    break;
                case 6:
                {
                    sendWeight.text('до 20 кг');
                    sizes.text('50x40x40');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('20');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '20'
                }
                    break;
                case 7:
                {
                    sendWeight.text('до 30 кг');
                    sizes.text('68x43x41');
                    var items=$('.sizes').text().split('x');
                    weight_input.val('30');
                    length_input.val(items[0]);
                    width_input.val(items[1]);
                    height_input.val(items[2]);
                    overweight.addClass('hidden');
                    return '30'
                }
                    break;
                case 8:
                {
                    sendWeight.text('больше 30 кг');
                    sizes.text('Обязательно');
                    weight_input.val('30');
                    length_input.val('');
                    width_input.val('');
                    height_input.val('');
                    overweight.removeClass('hidden');
                    return '30+';
                }
                    break;
            }
        }
    };

    function initSlider(slider) {

        if (slider.length) {

            if (slider.data('slider')) {
                slider.slider('destroy');
            }

            slider.slider(slider_settings);
        }
    }

    /**
     * Початкова ініціалізація слайдера
     */
    $(document).find('input[name="sliderOptionsSend"]').each(function () {
        var slider = $(this);
        initSlider(slider);
    });

    /**
     * Створення нового місця
     */
    addPlace.on('click', function () {

        if(posts===0)
        {
            var first = $(document).find('.cargo-element').first();
            var btn = first.find('.removeElement');
            btn.removeClass('hidden');
        }

        posts++;

        $.ajax({
            type: 'POST',
            data: {
                key: posts
            },
            url: '/document/add-cargo',
        }).done(function (element) {
            var new_cargo_element = $(element);
            new_cargo_element.find('.removeElement').removeClass('hidden');

            var slider = new_cargo_element.find('input[name="sliderOptionsSend"]');
            initSlider(slider);

            cargo_list.append(new_cargo_element);
        });
    });

    /**
     * Видалення місця
     */
    $(document).on('click', '.removeElement', function () {
        var remove_button = $(this);
        var confirm = window.confirm('Вы уверены, что хотите удалить место?');

        if (confirm === true) {
            remove_button.closest('.cargo-element').remove();
            posts--;

            $('.cargo-element-seats-amount').text(posts + 1);

            var places = cargo_list.find('.placeNum');

            for (var i = 0; i < places.length; i++) {
                cargo_list.find(places[i]).text('Место №' + (i + 1));
            }

            if (posts === 0) $(document).find('.removeElement').addClass('hidden');
        }
    });

    /**
     * Модальне вікно з розмірами
     */
    $(document).on('click', '.sizes', function () {
        var clicked = $(this);
        console.log(clicked);
        var items = ['', '', ''];
        if (clicked.text() !== 'Обязательно') {
            items = clicked.text().split('x');
        }
        $(document).find('#sizesDataModal').ready(function () {
            $('#modal-cargo-element-length').val(items[0]);
            $('#modal-cargo-element-width').val(items[1]);
            $('#modal-cargo-element-height').val(items[2]);
        });

        $(document).find('#sizesDataModal').on('click', '#save-sizes-data', function () {
            var sizesData = $('#sizesDataModal').find('.form-control');

            var data = [
                $('#' + sizesData[0].id).val(),
                $('#' + sizesData[1].id).val(),
                $('#' + sizesData[2].id).val(),
            ];

            if (data[0] !== '' && data[1] !== '' && data[2] !== '') {
                $(document).find(clicked).text(data[0] + 'x' + data[1] + 'x' + data[2]);

                $(document).find('#sizesDataModal').modal('hide');
            }
            else alert('Заполните все необходимые поля');
        });
        $(document).find('#sizesDataModal').modal('show');
    });

    /**
     *  Зміна типу документа
     */
    $('#cargo-type-send').on('click', function () {
        cargo_type.val('Cargo');
    });

    /**
     *  Зміна типу документа
     */
    $('#cargo-type-documents').on('click', function () {
        cargo_type.val('Documents');
    });
});