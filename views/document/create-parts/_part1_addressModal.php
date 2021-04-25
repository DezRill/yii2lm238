<?php
/* @var $model app\models\DocumentCreateRequest */

use yii\web\JsExpression;

/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */

$requestJsTowns = <<<JS
function(params) {
    var apiKey = $('#api_key').val();
    
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

$acceptAddress = <<< JS
$('#addressDataModal').on('click', '#save-address-data', function() {
  var recipientData = $('#addressDataModal').find('.form-control');
   
  var data = [
    $('#'+recipientData[0].id).find('option').last(),
    $('#'+recipientData[1].id).val(),
    $('#'+recipientData[2].id).val(),
    $('#'+recipientData[3].id).val(),
  ];
  
  if (data[0].text()!=='' && data[1]!=='' && data[2]!=='' && data[3]!=='')
  {
      $(document).find('#address').val(data[0].text()+', '+data[1]+' '+data[2]);
      
      $(document).find('#recipientTown').append(data[0]);

      $(document).find('#addressDataModal').modal('hide');
  }
  else alert ('Заполните все необходимые поля');
  
});
JS;
$this->registerJs($acceptAddress);

$townChanged = <<<JS
$('#addressDataModal').on('change', '#townToAddress', function() {
  var fields = $('#addressDataModal').find('.form-control');
  
  $('#'+fields[1].id).each(function() {
    $('#'+fields[1].id).val("");
  });
  $('#'+fields[2].id).each(function() {
    $('#'+fields[2].id).val("");
  });
  $('#'+fields[3].id).each(function() {
    $('#'+fields[3].id).val("");
  });
})
JS;
$this->registerJs($townChanged);

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<? /*= $form->field($model, 'recipientTown')->widget(\kartik\select2\Select2::class, [
    'initValueText' => null,
    'options' => ['id' => 'townToAddress'],
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
    ]
])->label('Город')*/ ?>

<div class="form-group">
    <?= \yii\helpers\Html::label('Город', null, ['class' => 'control-label']) ?>
    <?= \kartik\select2\Select2::widget([
        'initValueText' => null,
        'name' => 'recipientTown',
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
