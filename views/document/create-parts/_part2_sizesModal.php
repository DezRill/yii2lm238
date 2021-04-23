<?php

/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */

$acceptSizes = <<< JS
$('#sizesDataModal').on('click', '#save-sizes-data', function() {
  var sizesData = $('#sizesDataModal').find('.form-control');
   
  var data = [
    $('#'+sizesData[0].id).val(),
    $('#'+sizesData[1].id).val(),
    $('#'+sizesData[2].id).val(),
  ];
  
  if (data[0]!=='' && data[1]!=='' && data[2]!=='')
  {
    $(document).find('#sizes').text(data[0]+'x'+data[1]+'x'+data[2]);
    
    $(document).find('#sizesDataModal').modal('hide');
  }
  else alert ('Заполните все необходимые поля');
})
JS;
$this->registerJs($acceptSizes);

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<?= $form->field($model, 'seatParams[0][param]')->textInput(['id' => 'length'])->label('Длина') ?>

<?= $form->field($model, 'seatParams[0][param1]')->textInput(['id' => 'width'])->label('Ширина') ?>

<?= $form->field($model, 'seatParams[0][param2]')->textInput(['id' => 'height'])->label('Высота') ?>

<?= \yii\helpers\Html::button('Добавить', ['id' => 'save-sizes-data', 'class' => 'btn btn-success btn-save']); ?>
