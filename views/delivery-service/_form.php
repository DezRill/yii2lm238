<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryService */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="delivery-service-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if (Yii::$app->request->url==='/web/delivery-service/create') :  ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

        <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->label('Короткое название') ?>

        <?= $form->field($model, 'http_url')->dropDownList(['https://track.ukrposhta.ua/tracking_UA.html?barcode=' => 'Укрпошта', 'https://t.meest-group.com/' => 'Meest Express']) ?>

        <?= $form->field($model, 'as_default')->dropDownList([ '0', '1', ])->label('По умолчанию') ?>

        <?= $form->field($model, 'icon')->fileInput()->label('Иконка') ?>

    <?php else : ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

        <?= $form->field($model, 'short_name')->textInput(['maxlength' => true])->label('Короткое название') ?>

        <?php if ($model->id>1) : ?>

            <?= $form->field($model, 'http_url')->dropDownList(['https://track.ukrposhta.ua/tracking_UA.html?barcode=' => 'Укрпошта', 'https://t.meest-group.com/' => 'Meest Express']) ?>

        <?php endif;?>

        <?= $form->field($model, 'as_default')->dropDownList([ '0', '1', ])->label('По умолчанию') ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
