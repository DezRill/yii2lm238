<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DeliveryServiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Службы доставки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-service-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать службу доставки', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_delivery_item',
    ]); ?>


</div>
