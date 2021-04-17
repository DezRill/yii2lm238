<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $getDocumentsList app\models\document\request\DocumentListRequest */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
$(document).on('click', '#acceptButton', function() {
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
    <?php $form = ActiveForm::begin() ?>

    <?=Html::hiddenInput('apiKey',$getDocumentsList->apiKey,['class'=>'form-control'])?>
    <p>
    <h4><b><?= Html::encode('Дата от') ?></b></h4>
    <?= \kartik\date\DatePicker::widget([
        'model' => $getDocumentsList,
        'id' => 'dateFrom',
        'attribute' => 'dateFrom',
        'name' => 'dateFrom',
        'value' => $getDocumentsList->dateFrom,
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]) ?>
    </p>

    <p>
    <h4><b><?= Html::encode('Дата до') ?></b></h4>
    <?= \kartik\date\DatePicker::widget([
        'model' => $getDocumentsList,
        'id' => 'dateTo',
        'attribute' => 'dateTo',
        'name' => 'dateTo',
        'value' => $getDocumentsList->dateTo,
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ]) ?>
    </p>

    <div class="form-group" align="center">
        <?= Html::button('Применить', ['class' => 'btn btn-success', 'id' => 'acceptButton']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
