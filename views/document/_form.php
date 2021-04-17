<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $createDocument app\models\document\request\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($createDocument, 'payerType')->dropDownList(['']) ?>

    <?= $form->field($createDocument, 'paymentMethod')->dropDownList(['']) ?>

    <?= $form->field($createDocument, 'dateTime')->dropDownList(['']) ?>

    <?= $form->field($createDocument, 'cargoType')->dropDownList(['']) ?>

    <?= $form->field($createDocument, 'x')->textInput()->label('Длина') ?>

    <?= $form->field($createDocument, 'y')->textInput()->label('Ширина') ?>

    <?= $form->field($createDocument, 'z')->textInput()->label('Высота') ?>

    <div class="form-group">
        <?= Html::submitButton('Создать накладную', ['class' => 'btn btn-success', 'id' => 'createDocument', 'disabled' => true]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
