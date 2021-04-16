<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Накладные';
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['delivery-service/']];
$this->params['breadcrumbs'][] = ['label' => "Кабинеты", 'url' => ['delivery-service/view', 'id' => 1]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $documentSearch=new \app\models\DocumentSearch() ?>

    <?php \yii\bootstrap\Modal::begin([
        'id' => 'modal-window',
        'header' => '<h2>Введите даты</h2>',
        'toggleButton' => [
            'label' => 'Загрузить накладные',
            'tag' => 'button',
            'class' => 'btn btn-primary',
        ],
    ]) ?>
    <?= $this->render('_dateModal', compact('documentSearch')) ?>
    <?php \yii\bootstrap\Modal::end() ?>
    <?= Html::a('Создать накладную', ['create'], ['class' => 'btn btn-success']) ?>

    <? /*=
    ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_document_item',
    ]);
    */ ?>
</div>