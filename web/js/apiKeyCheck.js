$(document).on('blur','#cabinet-api_key', function() {
    var apiKey = $('#cabinet-api_key').val();

    var dataBody = JSON.stringify({
        modelName: "Counterparty",
        calledMethod: "getCounterparties",
        apiKey: apiKey,
        methodProperties: {
            CounterpartyProperty: "Sender",
        }
    });

    $.ajax({
        type: "POST",
        url: "https://api.novaposhta.ua/v2.0/json/",
        data: dataBody,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            if (data["success"]) {

                $('#cabinet-counterparty').each(function() {
                    this.disabled=false;
                });
                $('#cabinet-contact_person').each(function() {
                    this.disabled=false;
                });
                $('#cabinet-recipient_counterparty').each(function() {
                    this.disabled=false;
                });
                $('#cabinet-town').each(function() {
                    this.disabled=false;
                });
                $('#cabinet-dispatch_dep').each(function() {
                    this.disabled=false;
                })
                $('#saveCabinetButton').each(function() {
                    this.disabled=false;
                });
            }
            else {
                $('#cabinet-counterparty').each(function() {
                    this.disabled=true;
                    $('#cabinet-counterparty').val("");
                });
                $('#cabinet-contact_person').each(function() {
                    this.disabled=true;
                    $('#cabinet-contact_person').val("");
                });
                $('#cabinet-recipient_counterparty').each(function() {
                    this.disabled=true;
                    $('#cabinet-recipient_counterparty').val("");
                });
                $('#cabinet-town').each(function() {
                    this.disabled=true;
                    $('#cabinet-town').text("");
                });
                $('#cabinet-dispatch_dep').each(function() {
                    this.disabled=true;
                    $('#cabinet-dispatch_dep').text("");
                });
                $('#saveCabinetButton').each(function() {
                    this.disabled=true;
                });
                alert("Неправильный ключ API");
            }
        },
        error: function() {
            alert("Ошибка загрузки данных");
        }
    })
});