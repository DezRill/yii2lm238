$(document).ready(function () {
    var recipientData = $('#recipientDataModal').find('.form-control');

    var data = [
        $('#' + recipientData[0].id).val(),
        $('#' + recipientData[1].id).val(),
        $('#' + recipientData[2].id).val(),
        $('#' + recipientData[3].id).val()
    ];

    if (data[0] !== '' && data[1] !== '' && data[2] !== '') {
        $(document).find('#recipient').val(data[2] + ' ' + data[1] + ' ' + data[3] + ', ' + data[0]);
    }

    var pressed = $('input[type=radio]:checked');
    if (pressed.val()==='WarehouseWarehouse')
    {
        $('#address-group').addClass('hidden');
        $('#department-group').removeClass('hidden');
    }
});

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