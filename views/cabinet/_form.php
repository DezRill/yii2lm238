<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinet */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('@web/js/apiKeyCheck.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/counterPartyChanged.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerJsFile('@web/js/townChanged.js', ['depends' => 'yii\web\YiiAsset']);

$requestDataTowns = <<<JS
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

$resultsJsTowns = <<<JS
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

$requestDataDepartments = <<<JS
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

$resultsJsDepartments = <<<JS
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

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_end')->widget(\kartik\date\DatePicker::class, [
        'model' => $model,
        'attribute' => 'date_end',
        'name' => 'datePicker',
        'value' => $model->date_end,
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата окончания действия ключа') ?>

    <?= $form->field($model, 'counterparty')->dropDownList(getCounterparties($model->api_key), ['prompt' => '-', 'disabled' => true]) ?>

    <?= $form->field($model, 'contact_person')->dropDownList(getCounterpartyContactPerson($model->api_key, $model->counterparty), ['prompt' => '-', 'disabled' => true]) ?>

    <?= $form->field($model, 'recipient_counterparty')->dropDownList(getCounterparties($model->api_key), ['disabled' => true, 'prompt' => '-']) ?>

    <?= $form->field($model, 'town')->widget(\kartik\select2\Select2::class, [
        'initValueText' => !is_null($model->town) ? townRefToDescription($model->town, $model->api_key) : null,
        'options' => ['disabled' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestDataTowns),
                'processResults' => new JsExpression($resultsJsTowns),
                'cache' => true
            ],
        ],
    ]) ?>

    <?= $form->field($model, 'dispatch_dep')->widget(\kartik\select2\Select2::class, [
        'initValueText' => !is_null($model->dispatch_dep) ? departmentRefToDescription($model->dispatch_dep, $model->api_key) : null,
        'options' => ['disabled' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestDataDepartments),
                'processResults' => new JsExpression($resultsJsDepartments),
                'cache' => true
            ],
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-save"></span> Сохранить', ['class' => 'btn btn-success', 'id' => 'saveCabinetButton', 'disabled' => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
