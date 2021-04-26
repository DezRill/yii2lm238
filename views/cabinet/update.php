<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinet */

$this->title = 'Редактировать кабинет: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Службы доставки', 'url' => ['delivery-service/']];
$this->params['breadcrumbs'][] = ['label' => "Кабинеты", 'url' => ['delivery-service/view', 'id' => 1]];
$this->params['breadcrumbs'][] = 'Редактировать кабинет';
?>
<div class="cabinet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Удалить кабинет', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить кабинет?',
            'method' => 'post',
        ],
    ]) ?><br/><br/>

    <?php echo $this->render('_form', ['model' => $model]) ?>
</div>
