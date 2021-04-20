<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $getDocumentsList app\models\document\request\DocumentListRequest */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
$(document).on('click', '#acceptButtonDocument', function() {
  var modal_window = $('#modal-window');
  var sendData = modal_window.find('.form-control').serialize();
  var content  = $(document).find("#content");
  console.log(sendData);
  
  $.ajax({
    type: "POST",
    url: '/document/get-data',
    data: sendData
  }).done(function( msg ) {
    console.log(msg);
    content.html(msg);
    content.removeClass('hidden')
  });
  
  modal_window.modal('hide');
})
JS;
$this->registerJs($js);

?>

<div class="document-search-form">
    <?php $form = ActiveForm::begin(['id' => 'activeForm']) ?>

    <?= $form->field($getDocumentsList, 'apiKey', [
        'options' => [
            'class' => 'hidden'
        ]
    ])->hiddenInput(); ?>

    <?= $form->field($getDocumentsList, 'dateFrom')->widget(\kartik\date\DatePicker::class, [
        'model' => $getDocumentsList,
        'attribute' => 'dateFrom',
        'value' => $getDocumentsList->dateFrom,
        'name' => 'dateFrom',
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата от') ?>

    <?= $form->field($getDocumentsList, 'dateTo')->widget(\kartik\date\DatePicker::class, [
        'model' => $getDocumentsList,
        'attribute' => 'dateTo',
        'value' => $getDocumentsList->dateTo,
        'name' => 'dateTo',
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата до') ?>

    <div class="form-group" align="center">
        <?= Html::button('Применить', ['class' => 'btn btn-success', 'id' => 'acceptButtonDocument']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
