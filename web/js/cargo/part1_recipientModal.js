$('#recipientDataModal').on('click', '#save-user-data', function() {
    var recipientData = $('#recipientDataModal').find('.form-control');

    var data = [
        $('#'+recipientData[0].id).val(),
        $('#'+recipientData[1].id).val(),
        $('#'+recipientData[2].id).val(),
        $('#'+recipientData[3].id).val()
    ];

    if (data[0]!=='' && data[1]!=='' && data[2]!=='')
    {
        if (data[0].match(/\d/g).length===12)
        {
            $(document).find('#recipient').val(data[2]+' '+data[1]+' '+data[3]+', '+data[0]);

            $(document).find('#recipientDataModal').modal('hide');
        }
        else alert ('Заполните номер телефона получателя');
    }
    else alert ('Заполните все необходимые поля');
});