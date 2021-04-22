<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Document */
/* @var $cabinet app\models\Cabinet */

$this->title = 'Накладная: ' . $model->document_num;
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['index', 'id' => $cabinet->id]];
$this->params['breadcrumbs'][] = 'Редактировать';

$this->registerCssFile("@web/css/update_style.css");

?>
<div class="document-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'cabinet' => $cabinet,
        'messages' => $messages,
    ]) ?>

</div>
