<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$css = <<<CSS
.btn-save {
text-align: center;
}
.nav-pills > li {
    float:none;
    display:inline-block;
    zoom:1;
}

.nav-pills {
    text-align:center;
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
]
?>

<div class="document-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group btn-save">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-remove"></span> Отмена', ['index', 'id' => $cabinet->id], ['class' => 'btn btn-danger']) ?>
    </div>

    <div class="form-group">
        <?= Html::label('Служба доставки', 'delivery-service', ['class' => 'control-label']) ?>
        <?= Html::input('text', 'delivery-service', 'Nova Poshta', ['class' => 'form-control']) ?>
    </div>

    <?= $form->field($model, 'cabinet_id')->dropDownList($cabinets)->label('Кабинет') ?>

    <?= $form->field($model, 'document_num')->textInput(['maxlength' => true])->label('Номер') ?>

    <?= $form->field($model, 'current_status')->dropDownList($statuses)->label('Статус') ?>

    <br/>
    <ul class="nav nav-pills">
        <li class="active">
            <a data-toggle="tab" href="#statuses">Информация</a>
        </li>
        <li>
            <a data-toggle="tab" href="#description">Примечание</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="statuses">
            <?= \yii\widgets\ListView::widget([
                'dataProvider' => $messages,
                'itemView' => '_statusItem',
            ]) ?>
            </div >
        <div class="tab-pane" id = "description" >
            <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('') ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
