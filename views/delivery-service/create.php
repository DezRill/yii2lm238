<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeliveryService */

$this->title = 'Создать службу доставки';
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['/']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="delivery-service-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
