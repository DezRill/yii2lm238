<?php

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$this->registerJsFile('@web/js/cargo/part3.js', ['depends' => 'yii\web\YiiAsset']);
?>

<?php
$redelivery = [
    false => 'ВЫКЛ',
    true => 'ВКЛ',
];

$payer = [
    'Sender' => 'Отправитель',
    'Recipient' => 'Получатель'
];
?>

<div class="part3-form">
    <?= $form->field($model, 'cost')->textInput()->label('Оценочная стоимость') ?>

    <?= $form->field($model, 'description')->textInput()->label('Описание') ?>

    <?= $form->field($model, 'redelivery')->radioList($redelivery, ['class' => 'redelivery_tab'])->label('Обратная доставка') ?>

    <div class="redelivery-div hidden">
        <?= $form->field($model, 'redeliveryValue')->textInput()->label('Денежный перевод') ?>
    </div>

    <?= $form->field($model, 'payerType')->radioList($payer)->label('Оплата услуги доставки') ?>

    <div class="redelivery-div hidden">
        <?= $form->field($model, 'redeliveryPayer')->radioList($payer)->label('Оплата услуги обратной доставки') ?>
    </div>
</div>