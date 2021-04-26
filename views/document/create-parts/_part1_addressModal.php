<?php
/* @var $model app\models\DocumentCreateRequest */

use yii\web\JsExpression;

/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */
/* @var $cabinet app\models\Cabinet */

$requestJsTowns = <<<JS
function(params) {
    var apiKey = $(document).find('#api_key').val();
    
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

$this->registerJsFile('@web/js/cargo/part1_addressModal.js', ['depends' => 'yii\web\YiiAsset']);

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<div class="form-group">
    <?= \yii\helpers\Html::label('Город', null, ['class' => 'control-label']) ?>
    <?= \kartik\select2\Select2::widget([
        'initValueText' => !is_null($model->recipientTown) ? townRefToDescription($model->recipientTown, $cabinet->api_key) : null,
        'name' => 'recipientTown',
        'id' => 'townToAddressModal',
        'options' => ['class' => 'form-control'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestJsTowns),
                'processResults' => new JsExpression($resultsJsTowns),
                'cache' => true
            ]
        ]]) ?>
    <div class="help-block"></div>
</div>

<?= $form->field($model, 'street')->textInput()->label('Улица') ?>

<?= $form->field($model, 'house')->textInput()->label('Дом') ?>

<?= $form->field($model, 'flat')->textInput()->label('Квартира') ?>

<?= \yii\helpers\Html::button('Сохранить', ['id' => 'save-address-data', 'class' => 'btn btn-success btn-save']); ?>
