<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $downloadModel app\models\DocumentDownloadModel */

?>

<div class="document-search-form">
    <?php $form = ActiveForm::begin(['action' => 'download-documents?id=' . $cabinet->id]) ?>

    <?= $form->field($downloadModel, 'apiKey', [
        'options' => [
            'class' => 'hidden'
        ]
    ])->hiddenInput(); ?>

    <?= $form->field($downloadModel, 'dateFrom')->widget(\kartik\date\DatePicker::class, [
        'model' => $downloadModel,
        'attribute' => 'dateFrom',
        'value' => $downloadModel->dateFrom,
        'name' => 'dateFrom',
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата от') ?>

    <?= $form->field($downloadModel, 'dateTo')->widget(\kartik\date\DatePicker::class, [
        'model' => $downloadModel,
        'attribute' => 'dateTo',
        'value' => $downloadModel->dateTo,
        'name' => 'dateTo',
        'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy',
        ]
    ])->label('Дата до') ?>

    <div class="form-group" align="center">
        <?= Html::submitButton('Применить', ['class' => 'btn btn-success', 'id' => 'downloadDocumentButton']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>