<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cabinet */

$this->title = 'Редактировать кабинет: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Кабинеты', 'url' => ['delivery-service/view?id=1']];
?>
<div class="cabinet-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= Html::a('Удалить кабинет', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить кабинет?',
            'method' => 'post',
        ],
    ]) ?><br/><br/>

    <?php

        echo $this->render('_form', [
            'model' => $model,
            'counterparties' => $counterparties,
            'contactPersons' => $contactPersons,
    ]) ?>
</div>
