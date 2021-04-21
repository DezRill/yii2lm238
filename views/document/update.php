<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $cabinet app\models\Cabinet */

$this->title = 'Редактировать накладную: ' . $model->document_num;
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['index', 'id' => $cabinet->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

$this->registerCssFile("@web/css/status_item.css");

?>
<div class="document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cabinet' => $cabinet,
        'messages' => $messages,
    ]) ?>

</div>
