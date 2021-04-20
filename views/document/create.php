<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $createDocument app\models\document\request\DocumentCreateRequest */

$this->title = 'Создать накладную';
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['document/index', 'id' => $cabinet->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cabinet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'createDocument' => $createDocument,
        'cabinet' => $cabinet,
    ]) ?>
</div>
