<?php

use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */


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

$requestJsDepartments = <<<JS
function(params) {
    var apiKey = $('#api_key').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getWarehouses",
        apiKey: apiKey,
        methodProperties: {
            Limit:30,
            CityRef: $('#senderTown').val(),
            Page: params.page
        },
    });
    return query;
}
JS;

$requestJsDepartmentsRecipient = <<<JS
function(params) {
    var apiKey = $('#api_key').val();
    
    var query = JSON.stringify({
        modelName: "Address",
        calledMethod: "getWarehouses",
        apiKey: apiKey,
        methodProperties: {
            Limit:30,
            CityRef: $('#townToDepartment').val(),
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

$changeServiceType = <<<JS
$(document).on('change', 'input:radio', function() {
  var pressed=$(this);
  switch (pressed.val())
  {
      case 'WarehouseWarehouse':
          {
              $('#address-group').addClass('hidden');
              $('#department-group').removeClass('hidden');
          }
      break;
      case 'WarehouseDoors':
          {
              $('#address-group').removeClass('hidden');
              $('#department-group').addClass('hidden');
          }
      break;
  }
})
JS;
$this->registerJs($changeServiceType);

$checkFields = <<<JS
$(document).find('#parcel_tab').on('click', function(e) {
  switch ($('input:radio:checked').val())
  {
      case 'WarehouseDoors':
          {
              if ($('#address').val()==='' || $('#recipient').val()==='')
              {
                  e.preventDefault();
                  alert('Заполните все необходимые поля');
                  return false;
              } 
          }
      break;
          
      case 'WarehouseWarehouse':
          {
              if ($('#recipient').val()==='' || $('#townToDepartment').val()===null || $('#recipientDepartment').val()===null)
              {
                  e.preventDefault();
                  alert('Заполните все необходимые поля');
                  return false;
              }
          }
      break;
  }
})
JS;
$this->registerJs($checkFields);

$openModal = <<<JS
$(document).on('click', '#recipient', function() {
  $('#recipientDataModal').modal('show');
});

$(document).on('click', '#address', function() {
  $('#addressDataModal').modal('show');
});
JS;
$this->registerJs($openModal);

?>

<?php
$serviceTypeArray = [
    'WarehouseDoors' => 'Адрес',
    'WarehouseWarehouse' => 'Отделение',
];
?>

<div class="part1-form">

    <?= Html::input('text', 'api_key', $cabinet->api_key, ['class' => 'hidden', 'id' => 'api_key']) ?>

    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($model, 'date')->widget(DatePicker::class, [
        'model' => $model,
        'attribute' => 'date',
        'name' => 'date',
        'type' => DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата отправки') ?>

    <?= $form->field($model, 'senderTown')->widget(\kartik\select2\Select2::class, [
        'initValueText' => townRefToDescription($model->senderTown, $cabinet->api_key),
        'options' => ['id' => 'senderTown'],
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
    ])->label('Город') ?>

    <?= $form->field($model, 'senderDepartment')->widget(\kartik\select2\Select2::class, [
        'initValueText' => departmentRefToDescription($model->senderDepartment, $cabinet->api_key),
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 0,
            'ajax' => [
                'url' => "https://api.novaposhta.ua/v2.0/json/",
                'type' => 'POST',
                'dataType' => 'json',
                'delay' => 250,
                'data' => new JsExpression($requestJsDepartments),
                'processResults' => new JsExpression($resultsJsDepartments),
                'cache' => true
            ]
        ]
    ])->label('Отделение') ?>

    <?= $form->field($model, 'serviceType')->radioList($serviceTypeArray)->label('Место получения') ?>

    <div class="form-group" id="address-group">
        <?= Html::label('Адрес', '', ['control-label']) ?>
        <?= Html::textInput('address', '', ['class' => 'form-control', 'id' => 'address', 'readonly' => true]) ?>
    </div>
    <div class="form-group">
        <?= Html::label('Получатель', '', ['control-label']) ?>
        <?= Html::textInput('recipient', '', ['class' => 'form-control', 'id' => 'recipient', 'readonly' => true]) ?>
    </div>

    <div class="hidden" id="department-group">
        <?= $form->field($model, 'recipientTown')->widget(\kartik\select2\Select2::class, [
            'initValueText' => null,
            'options' => ['id' => 'townToDepartment'],
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
        ])->label('Город') ?>

        <?= $form->field($model, 'recipientDepartment')->widget(\kartik\select2\Select2::class, [
            'initValueText' => null,
            'options' => ['id' => 'recipientDepartment'],
            'pluginOptions' => [
                'allowClear' => true,
                'minimumInputLength' => 0,
                'ajax' => [
                    'url' => "https://api.novaposhta.ua/v2.0/json/",
                    'type' => 'POST',
                    'dataType' => 'json',
                    'delay' => 250,
                    'data' => new JsExpression($requestJsDepartmentsRecipient),
                    'processResults' => new JsExpression($resultsJsDepartments),
                    'cache' => true
                ]
            ]
        ])->label('Отделение') ?>
    </div>

    <?php
    \yii\bootstrap\Modal::begin([
        'id' => 'recipientDataModal',
        'header' => '<h2>Получатель</h2>'
    ]);
    echo $this->render('_part1_recipientModal', ['model' => $model, 'form' => $form]);
    \yii\bootstrap\Modal::end()
    ?>

    <?php
    \yii\bootstrap\Modal::begin([
        'id' => 'addressDataModal',
        'header' => '<h2>Адрес</h2>'
    ]);
    echo $this->render('_part1_addressModal', ['model' => $model, 'form' => $form]);
    \yii\bootstrap\Modal::end()
    ?>

    <?php ActiveForm::end() ?>

</div>
