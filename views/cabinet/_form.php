<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinet */
/* @var $form yii\widgets\ActiveForm */

$apiKeyCheckRequest = <<<JS
$(document).on('blur','#cabinet-api_key', function() {
    var apiKey = $('#cabinet-api_key').val();
    
    var data=JSON.stringify({
        modelName: "Counterparty",
        calledMethod: "getCounterparties",
        apiKey: apiKey,
        methodProperties: {
            CounterpartyProperty: "Sender",
        }
    })
});
JS;
$this->registerJs($apiKeyCheckRequest, $this::POS_END);

$townChanged =<<<JS
$(document).on('change', '#cabinet-town', function() {
  $('#cabinet-dispatch_dep').text("");
})
JS;
$this->registerJs($townChanged, $this::POS_END);



$requestData = <<<JS
function(params) {
    var apiKey = $('#cabinet-api_key').val();
    
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

$resultsJs = <<<JS
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

$requestData1 = <<<JS
function(params) {
    var apiKey = $('#cabinet-api_key').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getWarehouses",
        apiKey: apiKey,
        methodProperties: {
            Limit:30,
            CityRef: $('#cabinet-town').val(),
            Page: params.page
        },
    });
    return query;
}
JS;

$resultsJs1 = <<<JS
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

?>

<div class="cabinet-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'api_key')->textInput() ?>

    <h5><b><?= Html::encode('Дата окончания действия ключа') ?></b></h5>
    <?= \kartik\date\DatePicker::widget([
        'model' => $model,
        'attribute' => 'date_end',
        'name' => 'datePicker',
        'value' => $model->date_end,
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
        ]
    ]) ?><br/>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'counterparty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'contact_person')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'recipient_counterparty')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'town')->widget(\kartik\select2\Select2::class, [
        'initValueText' => !is_null($model->town) ? $model->town : null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestData),
                'processResults' => new JsExpression($resultsJs),
                'cache' => true
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'dispatch_dep')->widget(\kartik\select2\Select2::class, [
        'initValueText' => !is_null($model->dispatch_dep) ? $model->dispatch_dep : null,
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestData1),
                'processResults' => new JsExpression($resultsJs1),
                'cache' => true
            ],
        ],
    ]) ?>

    <?= '<pre>' . print_r($apiKeyCheckRequest, true) . '</pre>'; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
