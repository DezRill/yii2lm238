$('#addressDataModal').on('click', '#save-address-data', function() {
    var recipientData = $('#addressDataModal').find('.form-control');

    var data = [
        $('#'+recipientData[0].id).find('option').last(),
        $('#'+recipientData[1].id).val(),
        $('#'+recipientData[2].id).val(),
        $('#'+recipientData[3].id).val()
    ];

    if (data[0].text()!=='' && data[1]!=='' && data[2]!=='' && data[3]!=='')
    {
        $(document).find('#address').val(data[0].text()+', '+data[1]+' '+data[2]);

        $(document).find('#recipientTown').append(data[0]);

        $(document).find('#addressDataModal').modal('hide');
    }
    else alert ('Заполните все необходимые поля');
});

$('#addressDataModal').on('change', '#townToAddressModal', function() {
    var fields = $('#addressDataModal').find('.form-control');

    $('#'+fields[1].id).each(function() {
        $('#'+fields[1].id).val("");
    });
    $('#'+fields[2].id).each(function() {
        $('#'+fields[2].id).val("");
    });
    $('#'+fields[3].id).each(function() {
        $('#'+fields[3].id).val("");
    });
});