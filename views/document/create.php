<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */

$this->title = 'Создание накладной';
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['index', 'id' => $cabinet->id]];
$this->params['breadcrumbs'][] = $this->title;

\app\assets\CargoAsset::register($this);
?>

<div class="document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>
    <ul class="nav nav-pills nav-fill">
        <li class="nav-item active">
            <a class="nav-link" data-toggle="tab" href="#information"><span class="glyphicon glyphicon-file"></span>
                Информация</a>
        </li>
        <li id="parcel_tab" class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#parcel"> <span class="glyphicon glyphicon-envelope"></span>
                Посылка</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#payment"> <span class="glyphicon glyphicon-usd"></span> Оплата</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="information">
            <?= $this->render('create-parts/_create_part1', ['model' => $model, 'cabinet' => $cabinet, 'form' => $form]) ?>
        </div>
        <div class="tab-pane" id="parcel">
            <?= $this->render('create-parts/_create_part2', ['model' => $model, 'cabinet' => $cabinet, 'form' => $form]) ?>
        </div>
        <div class="tab-pane" id="payment">
            <?= $this->render('create-parts/_create_part3', ['model' => $model, 'cabinet' => $cabinet, 'form' => $form]) ?>
        </div>
    </div>
    <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Создать', ['class' => 'btn btn-primary acceptBtn']) ?>
    <?php ActiveForm::end() ?>
</div>


<?php
\yii\bootstrap\Modal::begin([
    'id' => 'sizesDataModal',
    'header' => '<h2>Габариты</h2>'
]);
echo $this->render('create-parts/_part2_sizesModal', ['model' => $model, 'form' => $form]);
\yii\bootstrap\Modal::end()
?>
