<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinet */

$this->title = 'Создать кабинет';
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['/']];
$this->params['breadcrumbs'][] = ['label' => 'Кабинеты', 'url' => ['delivery-service/view?id=1']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
