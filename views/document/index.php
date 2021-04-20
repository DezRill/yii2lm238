<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $getDocumentsList app\models\document\request\DocumentListRequest */

$this->title = 'Накладные';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="document-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php \yii\bootstrap\Modal::begin([
        'id' => 'modal-window',
        'header' => '<h2>Введите даты</h2>',
        'toggleButton' => [
            'label' => 'Загрузить накладные',
            'tag' => 'button',
            'class' => 'btn btn-primary',
        ],
    ]) ?>
    <?= $this->render('_dateModal', ['getDocumentsList' => $getDocumentsList]) ?>
    <?php \yii\bootstrap\Modal::end() ?>
    <?= Html::a('Создать накладную', ['create', 'id' => $cabinet->id], ['class' => 'btn btn-success']) ?>

    <div id="content" class="hidden"></div>
</div>