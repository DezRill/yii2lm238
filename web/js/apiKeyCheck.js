$(document).on('change', '#cabinet-api_key', function () {
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
        success: function (data) {
            if (data["success"]) {
                $('#cabinet-counterparty').each(function () {
                    this.disabled = false;
                    $('#cabinet-counterparty').empty();
                    $('#cabinet-counterparty').append($('<option></option>').val('0').text("-"));
                });
                $('#cabinet-recipient_counterparty').each(function () {
                    this.disabled = false;
                    $('#cabinet-recipient_counterparty').empty();
                    $('#cabinet-recipient_counterparty').append($('<option></option>').val('0').text("-"));
                });
                $('#cabinet-town').each(function () {
                    this.disabled = false;
                });
                $('#cabinet-dispatch_dep').each(function () {
                    this.disabled = false;
                })
                $('#saveCabinetButton').each(function () {
                    this.disabled = false;
                });

                for (let item of data["data"]) {
                    $('#cabinet-counterparty').append($('<option></option>').val(item["Ref"]).text(item["Description"]));
                    $('#cabinet-recipient_counterparty').append($('<option></option>').val(item["Ref"]).text(item["Description"]));
                }
            }
            else {
                $('#cabinet-counterparty').each(function () {
                    this.disabled = true;
                    $('#cabinet-counterparty').empty();
                    $('#cabinet-counterparty').append($('<option></option>').val('0').text("-"));
                });
                $('#cabinet-contact_person').each(function () {
                    this.disabled = true;
                    $('#cabinet-contact_person').empty();
                    $('#cabinet-contact_person').append($('<option></option>').val('0').text("-"));
                });
                $('#cabinet-recipient_counterparty').each(function () {
                    this.disabled = true;
                    $('#cabinet-recipient_counterparty').empty();
                    $('#cabinet-recipient_counterparty').append($('<option></option>').val('0').text("-"));
                });
                $('#cabinet-town').each(function () {
                    this.disabled = true;
                    $('#cabinet-town').text("");
                });
                $('#cabinet-dispatch_dep').each(function () {
                    this.disabled = true;
                    $('#cabinet-dispatch_dep').text("");
                });
                $('#saveCabinetButton').each(function () {
                    this.disabled = true;
                });

                alert("Данный ключ недействителен");
            }
        },
        error: function () {
            alert("Ошибка загрузки данных");
        }
    })
});

$(document).ready(function () {
    if ($("#cabinet-api_key").val()) {
        $('#cabinet-counterparty').each(function () {
            this.disabled = false;
        });
        if (!$('#cabinet-counterparty').val("0")) {
            $('#cabinet-contact_person').each(function () {
                this.disabled = false;
            });
        }
        $('#cabinet-recipient_counterparty').each(function () {
            this.disabled = false;
        });
        $('#cabinet-town').each(function () {
            this.disabled = false;
        });
        $('#cabinet-dispatch_dep').each(function () {
            this.disabled = false;
        })
        $('#saveCabinetButton').each(function () {
            this.disabled = false;
        });
    }
});

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
                    $('#cabinet-contact_person').append($('<option></option>').text(item["Description"]));
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