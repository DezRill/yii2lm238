<?php

/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */

$this->registerJsFile('@web/js/cargo/part1_recipientModal.js', ['depends' => 'yii\web\YiiAsset']);

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<?= $form->field($model, 'recipientsPhone')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '+380999999999'
])->label('Телефон') ?>

<?= $form->field($model, 'firstName')->textInput()->label('Имя') ?>

<?= $form->field($model, 'secondName')->textInput()->label('Фамилия') ?>

<?= $form->field($model, 'lastName')->textInput()->hint('Необязательно')->label('Отчество') ?>

<?= \yii\helpers\Html::button('Сохранить', ['id' => 'save-user-data', 'class' => 'btn btn-success btn-save']); ?>
