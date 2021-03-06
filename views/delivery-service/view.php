<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryService */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="delivery-service-view">
    <p>
        <?php if (!$dataProvider) : ?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить службу доставки?',
            'method' => 'post',
        ],
    ]) ?>
    <?= $this->render('_delivery_view', ['model' => $model]); ?>
    <?php else : ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> Редактировать службу', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <h1><?= Html::encode('Кабинеты') ?></h1>
        <?= Html::a('<span class="glyphicon glyphicon-user"></span> Создать кабинет', ['cabinet/create'], ['class' => 'btn btn-success']) ?>
        <br/><br/>
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_np_cabinets',
        ]); ?>
    <?php endif; ?>
    </p>
</div>
