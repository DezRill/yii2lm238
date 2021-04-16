$(document).on('change', '#cabinet-counterparty', function () {
    $('#cabinet-contact_person').empty();
    $('#cabinet-contact_person').append($('<option></option>').val('0').text("-"));

    var apiKey = $('#cabinet-api_key').val();
    var dataBody = JSON.stringify({
        modelName: "Counterparty",
        calledMethod: "getCounterpartyContactPersons",
        apiKey: apiKey,
        methodProperties: {
            Ref: $("#cabinet-counterparty").val(),
        }
    });

    $.ajax({
        type: "POST",
        url: "https://api.novaposhta.ua/v2.0/json/",
        data: dataBody,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function (data) {
            if (data["success"]) {
                $('#cabinet-contact_person').each(function () {
                    this.disabled = false;
                });
                for (let item of data["data"]) {
                    $('#cabinet-contact_person').append($('<option></option>').val(item["Ref"]).text(item["Description"]));
                }
            }
            else {
                $('#cabinet-contact_person').each(function () {
                    this.disabled = true;
                    $('#cabinet-contact_person').empty();
                    $('#cabinet-contact_person').append($('<option></option>').val('0').text("-"));
                });
            }
        },
        error: function () {
            alert("Ошибка загрузки данных");
        }
    });
});