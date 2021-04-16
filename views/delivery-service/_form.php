<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

    <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->label('Короткое название') ?>

    <?php if ($model->id !== 1) : ?>
        <?= $form->field($model, 'http_url')->dropDownList(['https://track.ukrposhta.ua/tracking_UA.html?barcode=' => 'Укрпошта', 'https://t.meest-group.com/' => 'Meest Express']) ?>
    <?php endif; ?>

    <?//= $form->field($model, 'as_default')->dropDownList(['0' => 'Нет', '1' => "Да",])->label('По умолчанию') ?>

    <?php if ($model->id !== 1) : ?>
    <?= $form->field($model, 'icon', [
        'options' => [
            'class' => 'hidden'
        ]
    ])->hiddenInput() ?>

    <?php \yii\bootstrap\Modal::begin([
        'id' => 'modal-window',
        'header' => '<h2>Выберите иконку</h2>',
        'toggleButton' => [
            'label' => 'Иконка...',
            'tag' => 'button',
            'class' => 'btn btn-primary',
        ],
    ]) ?>
    <?= $this->render('_images', ['model' => $model]) ?>
    <?php \yii\bootstrap\Modal::end() ?><br/><br/>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
