<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryService */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="delivery-service-view">
    <p>
        <?php if ($model->id>1) : ?>
            <h1><?= Html::encode($this->title) ?></h1>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить службу доставки?',
                    'method' => 'post',
                ],
            ]) ?>
            <?= $this->render('_delivery_view', ['model' => $model]); ?>
        <?php else : ?>
            <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <h1>Кабинеты</h1>
        <?php endif; ?>
    </p>

    <?php /*echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'short_name',
            'icon',
            'http_url:url',
            'as_default',
        ],
    ])*/?>
</div>
