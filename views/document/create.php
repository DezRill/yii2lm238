<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $createDocument app\models\document\request\DocumentCreateRequest */

$this->title = 'Создать накладную';
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['/']];
$this->params['breadcrumbs'][] = ['label' => 'Кабинеты', 'url' => ['delivery-service/view?id=1']];
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['document/index', 'apiKey' => $createDocument->apiKey]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'createDocument' => $createDocument,
    ]) ?>

    <div id="content" class="hidden"></div>
</div>
