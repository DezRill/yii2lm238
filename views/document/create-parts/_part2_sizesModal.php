<?php

/* @var $model app\models\DocumentCreateRequest */

use yii\helpers\Html;

/* @var $form yii\widgets\ActiveForm */
/* @var $this yii\web\View */

$acceptBtnStyle = <<<CSS
.btn-save {
    width: 100%;
}
CSS;
$this->registerCss($acceptBtnStyle);
?>

<div class="form-group">
    <?= Html::label('Длина', '', ['class' => 'control-label']) ?>
    <?= Html::input('text', 'modal-length', '', ['class' => 'form-control', 'id' => 'modal-cargo-element-length']) ?>
    <div class="help-block"></div>

    <?= Html::label('Ширина', '', ['class' => 'control-label']) ?>
    <?= Html::input('text', 'modal-width', '', ['class' => 'form-control', 'id' => 'modal-cargo-element-width']) ?>
    <div class="help-block"></div>

    <?= Html::label('Высота', '', ['class' => 'control-label']) ?>
    <?= Html::input('text', 'modal-height', '', ['class' => 'form-control', 'id' => 'modal-cargo-element-height']) ?>
    <div class="help-block"></div>
</div>

<?= \yii\helpers\Html::button('Добавить', ['id' => 'save-sizes-data', 'class' => 'btn btn-success btn-save']); ?>
