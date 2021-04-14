$("document").ready(function () {
        var apiKey = "$model->api_key";

        if (apiKey) {
            if ("$model->town") {
                let dataBody = JSON.stringify({
                    modelName: "Address",
                    calledMethod: "getCities",
                    apiKey: apiKey,
                    methodProperties: {
                        Ref: "$model->town",
                    }
                });

                $.ajax({
                        type: "POST",
                        url: "https://api.novaposhta.ua/v2.0/json/",
                        data: dataBody,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(data) {
                            data.data.map(function(item) {
                                /*$('#cabinet-town').each(function () {
                                    $('#cabinet-dispatch_dep').text(item["Description"]);
                                })*/
                                alert(item["Description"]);
                            })
                        },
                        error: function(message) {
                            alert(message);
                        }
                    }
                );
            }

            if ("$model->dispatch_dep") {
                let dataBody = JSON.stringify({
                    modelName: "Address",
                    calledMethod: "getWarehouses",
                    apiKey: apiKey,
                    methodProperties: {
                        Ref: "$model->dispatch_dep",
                    }
                });

                $.ajax({
                        type: "POST",
                        url: "https://api.novaposhta.ua/v2.0/json/",
                        data: dataBody,
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        success: function(data) {
                            data.data.map(function (item) {
                                /*$('#cabinet-dispatch_dep').each(function () {
                                        $('#cabinet-dispatch_dep').text(item["Description"]);
                                    })*/
                                alert(item["Description"]);
                            })
                        },
                        error: function(message) {
                            alert(message);
                        }
                    }
                );
            }
        }
    }
);