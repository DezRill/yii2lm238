<?php

use \yii\widgets\ActiveForm;
use \yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-search-form">
    <?php $form = ActiveForm::begin() ?>

    <p>
        <h4><b><?= Html::encode('Дата от') ?></b></h4>
        <?= \kartik\date\DatePicker::widget([
            'model' => $model,
            'attribute' => 'date_end',
            'name' => 'datePicker',
            'value' => $model->dateFrom,
            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
            ]
        ]) ?>
    </p>

    <p>
        <h4><b><?= Html::encode('Дата до') ?></b></h4>
        <?= \kartik\date\DatePicker::widget([
            'model' => $model,
            'attribute' => 'date_end',
            'name' => 'datePicker',
            'value' => $model->dateTo,
            'type' => \kartik\date\DatePicker::TYPE_COMPONENT_PREPEND,
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'dd-mm-yyyy',
            ]
        ]) ?>
    </p>

    <div class="form-group" align="center">
        <?= Html::button('Применить', ['class' => 'btn btn-success', 'id' => 'acceptButton']) ?>
    </div>

    <?php ActiveForm::end() ?>
</div>
