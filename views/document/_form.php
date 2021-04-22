<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$css = <<<CSS
.nav-pills {
    text-align:center;
}

.nav-pills > li {
    float:none;
    display:inline-block;
    zoom:1;
}
CSS;
$this->registerCss($css);
?>

<?php
$cabinets = [];
foreach (\app\models\Cabinet::find()->select(['id', 'name'])->all() as $item) {
    $cabinets += [$item['id'] => $item['name']];
}

$statuses = [
    '1' => 'Оформление',
    '2' => 'Отправлено',
    '3' => 'Доставлен',
    '4' => 'Отказ',
];

$services = [];
foreach (\app\models\DeliveryService::find()->select(['id', 'name'])->all() as $item)
{
    $services+=[$item['id'] => $item['name']];
}
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group btn-save">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Отмена', ['index', 'id' => $cabinet->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <div class="form-group">
        <?= Html::label('Служба доставки', 'delivery-service', ['class' => 'control-label']) ?>
        <?= Html::dropDownList('services', 1, $services, ['class' => 'form-control']) ?>
    </div>

    <?= $form->field($model, 'cabinet_id')->dropDownList($cabinets)->label('Кабинет') ?>

    <?= $form->field($model, 'document_num')->textInput(['maxlength' => true])->label('Номер') ?>

    <?= $form->field($model, 'current_status')->dropDownList($statuses)->label('Статус') ?>

    <br/>
    <ul class="nav nav-pills">
        <li class="active">
            <a data-toggle="tab" href="#statuses"><span class="glyphicon glyphicon-file"></span> Информация</a>
        </li>
        <li>
            <a data-toggle="tab" href="#description"> <span class="glyphicon glyphicon-comment"></span> Примечание</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="statuses">
            <div class="statuses-header">
                <div class="date-header">
                    <b>Дата</b>
                </div>
                <div class="status-header">
                    <b>Статус</b>
                </div>
            </div>
            <hr class="hr-line" />
            <div class="list-view">
                <?= \yii\widgets\ListView::widget([
                    'dataProvider' => $messages,
                    'itemView' => '_statusItem',
                    'summary' => ''
                ]) ?>
            </div>
        </div>
        <div class="tab-pane" id="description">
            <?= $form->field($model, 'description')->textarea(['rows' => 8])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
