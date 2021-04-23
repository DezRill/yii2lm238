<?php

/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */

$acceptRecipient = <<< JS
$('#recipientDataModal').on('click', '#save-user-data', function() {
  var recipientData = $('#recipientDataModal').find('.form-control');
   
  var data = [
    $('#'+recipientData[0].id).val(),
    $('#'+recipientData[1].id).val(),
    $('#'+recipientData[2].id).val(),
    $('#'+recipientData[3].id).val(),
  ];
  
  if (data[0]!=='' && data[1]!=='' && data[2]!=='' && data[3]!=='')
  {
    if (data[0].match(/\d/g).length===13)
        {
            $(document).find('#recipient').val(data[2]+' '+data[1]+' '+data[3]+', '+data[0]);
    
            $(document).find('#recipientDataModal').modal('hide');
        }
    else alert ('Заполните номер телефона получателя');
  }
  else alert ('Заполните все необходимые поля');
})
JS;
$this->registerJs($acceptRecipient);

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '+3809999999999'
])->label('Телефон') ?>

<?= $form->field($model, 'firstName')->textInput()->label('Имя') ?>

<?= $form->field($model, 'secondName')->textInput()->label('Фамилия') ?>

<?= $form->field($model, 'lastName')->textInput()->label('Отчество') ?>

<?= \yii\helpers\Html::button('Сохранить', ['id' => 'save-user-data', 'class' => 'btn btn-success btn-save']); ?>
