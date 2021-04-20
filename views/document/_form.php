<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $createDocument app\models\document\request\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$requestSenderCity = <<<JS

function(params) {
    var apiKey = $('#apiKey').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getCities",
        apiKey: apiKey,
        methodProperties: {
            FindByString: params.term,
            Limit:30,
            Page: params.page
        },
    });
    return query;
}
JS;

$resultsSenderCity = <<<JS
function (response, params) {

    params.page = params.page || 1;

    return {
        results: response.data.map(function(item) {
            var text =item["Description"];
            return {
                id : item.Ref,
                text : text
            };
        }),
        pagination: {
            more: (params.page * 30) < Number(response.info.totalCount)
        }
    };
}
JS;

$requestRecipientCity = <<<JS
function(params) {
    var apiKey = $('#apiKey').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getCities",
        apiKey: apiKey,
        methodProperties: {
            FindByString: params.term,
            Limit:30,
            Page: params.page
        },
    });
    return query;
}
JS;

$resultsRecipientCity = <<<JS
function (response, params) {

    params.page = params.page || 1;

    return {
        results: response.data.map(function(item) {
            var text =item["Description"];
            return {
                id : item.Ref,
                text : text
            };
        }),
        pagination: {
            more: (params.page * 30) < Number(response.info.totalCount)
        }
    };
}
JS;

$requestSenderAddress = <<<JS
function(params) {
    var apiKey = $('#apiKey').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getWarehouses",
        apiKey: apiKey,
        methodProperties: {
            Limit:30,
            CityRef: $('#documentcreaterequest-citysender').val(),
            Page: params.page
        },
    });
    return query;
}
JS;

$resultsSenderAddress = <<<JS
function (response, params) {

    params.page = params.page || 1;

    return {
        results: response.data.map(function(item) {
            var text =item["Description"];
            return {
                id : item.Ref,
                text : text
            };
        }),
        pagination: {
            more: (params.page * 30) < Number(response.info.totalCount)
        }
    };
}
JS;

$requestRecipientAddress = <<<JS
function(params) {
    var apiKey = $('#apiKey').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getWarehouses",
        apiKey: apiKey,
        methodProperties: {
            Limit:30,
            CityRef: $('#documentcreaterequest-cityrecipient').val(),
            Page: params.page
        },
    });
    return query;
}
JS;

$resultsRecipientAddress = <<<JS
function (response, params) {

    params.page = params.page || 1;

    return {
        results: response.data.map(function(item) {
            var text =item["Description"];
            return {
                id : item.Ref,
                text : text
            };
        }),
        pagination: {
            more: (params.page * 30) < Number(response.info.totalCount)
        }
    };
}
JS;

$send = <<<JS
$(document).on('click', '#createDocument', function() {
    var form=$('#w0');
    var content = $('#content');
    var sendData = form.find('.form-control').serialize();
    console.log(sendData);
    
    $.ajax({
        type: "POST",
        url: '/document/send-data',
        data: sendData,
    }).done(function(msg) {
        console.log(msg);
        content.html(msg);
        content.removeClass('hidden');
    })
})
JS;
$this->registerJs($send);

?>

<?php
$payerTypeArray = [
    'Sender' => 'Отправитель',
    'Recipient' => 'Получатель',
    'ThirdPerson' => 'Третье лицо',
];
$paymentMethodArray = [
    'Cash' => 'Наличный расчёт',
    'NonCash' => 'Безналичный расчёт',
];
$cargoTypeArray = [
    'Cargo' => 'Груз',
    'Documents' => 'Документы',
    'TiresWheels' => 'Шины-диски',
    'Pallet' => 'Палеты',
    'Parcel' => 'Посылка',
];
$serviceTypeArray = [
    'WarehouseWarehouse' => 'Склад-Склад',
    'WarehouseDoors' => 'Склад-Дверь',
];
?>

<div class="document-form">

    <?php
    $createDocument->sender=$cabinet->counterparty;
    $createDocument->contactSender=$cabinet->contact_person;
    ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($cabinet, 'api_key', ['options' => ['class' => 'hidden', 'id' => 'apiKey']])->hiddenInput() ?>

    <?= $form->field($createDocument, 'dateTime')->widget(\kartik\date\DatePicker::class, [
        'model' => $createDocument,
        'attribute' => 'dateTime',
        'name' => 'dateTime',
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата отправки') ?>

    <?= $form->field($createDocument, 'citySender')->widget(\kartik\select2\Select2::class, [
        'initValueText' => townRefToDescription($cabinet->town, $cabinet->api_key),
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestSenderCity),
                'processResults' => new JsExpression($resultsSenderCity),
                'cache' => true
            ],
        ],
    ])->label('Город') ?>

    <?= $form->field($createDocument, 'senderAddress')->widget(\kartik\select2\Select2::class, [
        'initValueText' => departmentRefToDescription($cabinet->dispatch_dep, $cabinet->api_key),
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestSenderAddress),
                'processResults' => new JsExpression($resultsSenderAddress),
                'cache' => true
            ],
        ],
    ])->label('Отделение') ?>

    <?= $form->field($createDocument, 'payerType')->dropDownList($payerTypeArray)->label('Плательщик') ?>

    <?= $form->field($createDocument, 'paymentMethod')->dropDownList($paymentMethodArray)->label('Форма оплаты') ?>

    <?= $form->field($createDocument, 'cargoType')->dropDownList($cargoTypeArray)->label('Тип груза') ?>

    <?= $form->field($createDocument, 'volumetricWidth')->textInput()->label('Ширина') ?>

    <?= $form->field($createDocument, 'volumetricLength')->textInput()->label('Длина') ?>

    <?= $form->field($createDocument, 'volumetricHeight')->textInput()->label('Высота') ?>

    <?= $form->field($createDocument, 'weight')->textInput()->label('Вес') ?>

    <?= $form->field($createDocument, 'serviceType')->dropDownList($serviceTypeArray)->label('Технология доставки') ?>

    <?= $form->field($createDocument, 'seatsAmount')->textInput()->label('Количество мест') ?>

    <?= $form->field($createDocument, 'description')->textInput()->label('Описание груза') ?>

    <?= $form->field($createDocument, 'cost')->textInput()->label('Объявленная стоимость') ?>

    <?= $form->field($createDocument, 'contactSender')->textInput()->label('Контактное лицо отправителя') ?>

    <?= $form->field($createDocument, 'senderPhone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+380999999999'
    ])->label('Телефон отправителя') ?>

    <?= $form->field($createDocument, 'cityRecipient')->widget(\kartik\select2\Select2::class, [
        'initValueText' => null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestRecipientCity),
                'processResults' => new JsExpression($resultsRecipientCity),
                'cache' => true
            ],
        ],
    ])->label('Город получателя') ?>

    <? //= $form->field($createDocument, 'recipient')->dropDownList($senderArray)->label('Отправитель') ?>

    <?= $form->field($createDocument, 'recipient')->textInput()->label('Получатель') ?>

    <?= $form->field($createDocument, 'recipientAddress')->widget(\kartik\select2\Select2::class, [
        'initValueText' => null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestRecipientAddress),
                'processResults' => new JsExpression($resultsRecipientAddress),
                'cache' => true
            ],
        ],
    ])->label('Адрес получателя') ?>

    <? //= $form->field($createDocument, 'contactSender')->dropDownList($contactSenderArray)->label('Контактное лицо отправителя') ?>

    <?= $form->field($createDocument, 'contactRecipient')->textInput()->label('Контактное лицо получателя') ?>

    <?= $form->field($createDocument, 'recipientPhone')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '+380999999999'
    ])->label('Телефон получателя') ?>

    <div class="form-group">
        <?= Html::button('Создать накладную', ['class' => 'btn btn-success', 'id' => 'createDocument']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
