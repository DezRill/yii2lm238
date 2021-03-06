$(document).on('change', '#cabinet-api_key', function () {
    $('#cabinet-counterparty').each(function () {
        this.disabled = false;
        $('#cabinet-counterparty').empty();
        $('#cabinet-counterparty').append($('<option></option>').val('0').text("-"));
    });
    $('#cabinet-contact_person').each(function () {
        this.disabled = true;
        $('#cabinet-contact_person').empty();
        $('#cabinet-contact_person').append($('<option></option>').val('0').text("-"));
    });
    $('#cabinet-recipient_counterparty').each(function () {
        this.disabled = false;
        $('#cabinet-recipient_counterparty').empty();
        $('#cabinet-recipient_counterparty').append($('<option></option>').val('0').text("-"));
    });
    $('#cabinet-town').each(function () {
        this.disabled = false;
        $('#cabinet-town').text("");
    });
    $('#cabinet-dispatch_dep').each(function () {
        this.disabled = false;
        $('#cabinet-dispatch_dep').text("");
    })
    $('#saveCabinetButton').each(function () {
        this.disabled = false;
    });

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
                for (let item of data["data"]) {
                    $('#cabinet-counterparty').append($('<option></option>').val(item["Ref"]).text(item["Description"]));
                    $('#cabinet-counterparty select').val(item["Ref"]);
                    $('#cabinet-recipient_counterparty').append($('<option></option>').val(item["Ref"]).text(item["Description"]));
                    $('#cabinet-recipient_counterparty select').val(item["Ref"]);
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

                alert("???????????? ???????? ????????????????????????????");
            }
        },
        error: function () {
            alert("???????????? ???????????????? ????????????");
        }
    })
});

$(document).ready(function () {
    if ($("#cabinet-api_key").val()) {
        $('#cabinet-counterparty').each(function () {
            this.disabled = false;
        });
        $('#cabinet-contact_person').each(function () {
            this.disabled = false;
        });
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