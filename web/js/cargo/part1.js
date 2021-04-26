/**
 * На случай ошибки заполнения данных, чтобы сразу нужные поля отображались с нужной информацией
 */

$(document).ready(function () {
    var recipientData = $('#recipientDataModal').find('.form-control');
    var addressData = $('#addressDataModal').find('.form-control');

    var dataRecipient = [
        $('#' + recipientData[0].id).val(),
        $('#' + recipientData[1].id).val(),
        $('#' + recipientData[2].id).val(),
        $('#' + recipientData[3].id).val()
    ];

    var dataAddress = [
        $('#recipientTown').find('option').last(),
        $('#' + addressData[1].id).val(),
        $('#' + addressData[2].id).val(),
        $('#' + addressData[3].id).val()
    ];

    if (dataRecipient[0] !== '' && dataRecipient[1] !== '' && dataRecipient[2] !== '') {
        $(document).find('#recipient').val(dataRecipient[2] + ' ' + dataRecipient[1] + ' ' + dataRecipient[3] + ', ' + dataRecipient[0]);
    }

    if (dataAddress[0].text() !== '' && dataAddress[1] !== '' && dataAddress[2] !== '' && dataAddress[3] !== '') {
        $(document).find('#address').val(dataAddress[0].text() + ', ' + dataAddress[1] + ' ' + dataAddress[2]);
        $(document).find('#townToAddressModal').append(dataAddress[0]);
    }

    var pressed = $('input[type=radio]:checked');
    if (pressed.val() === 'WarehouseWarehouse') {
        $('#address-group').addClass('hidden');
        $('#department-group').removeClass('hidden');
    }
});

/**
 * Отображение и скрытие полей при смене чека
 */

$(document).on('change', 'input:radio', function () {
    var pressed = $(this);
    switch (pressed.val()) {
        case 'WarehouseWarehouse': {
            $('#address-group').addClass('hidden');
            $('#department-group').removeClass('hidden');
        }
            break;
        case 'WarehouseDoors': {
            $('#address-group').removeClass('hidden');
            $('#department-group').addClass('hidden');
        }
            break;
    }
});

/**
 * Если какие-то поля об контрагентах не заполнены, перейти на вкладку груза нельзя будет
 */

$(document).find('#parcel_tab').on('click', function (e) {
    switch ($('input:radio:checked').val()) {
        case 'WarehouseDoors': {
            if ($('#address').val() === '' || $('#recipient').val() === '') {
                e.preventDefault();
                alert('Заполните все необходимые поля');
                return false;
            }
        }
            break;

        case 'WarehouseWarehouse': {
            if ($('#recipient').val() === '' || $('#townToDepartment').val() === null || $('#recipientDepartment').val() === null) {
                e.preventDefault();
                alert('Заполните все необходимые поля');
                return false;
            }
        }
            break;
    }
});

$(document).on('click', '#recipient', function () {
    $('#recipientDataModal').modal('show');
});

$(document).on('click', '#address', function () {
    $('#addressDataModal').modal('show');
});