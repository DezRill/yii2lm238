<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cabinet app\models\Cabinet */

$this->title = 'Накладные';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/item.css");
$this->registerCssFile("@web/css/document_item.css");

$this->registerJsFile('@web/js/documentIndex.js', ['depends' => 'yii\web\YiiAsset']);
?>
<div class="document-index">

    <div class="flash-notification">

    </div>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <div class="actions-div">
        <?= Html::a('Создать накладную', ['create', 'id' => $cabinet->id], ['class' => 'btn btn-success']) ?>
        <div class="massive-operations">
            <?= Html::button('<span class="glyphicon glyphicon-repeat"></span>' . ' Обновить статус', ['class' => 'btn btn-primary', 'id' => 'updateAllBtn']) ?>
            <?= Html::button('<span class="glyphicon glyphicon-trash"></span>' . ' Удалить', ['class' => 'btn btn-danger', 'id' => 'deleteAllBtn']) ?>
        </div>
    </div>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_documentItem',
        'summary' => '',
    ])
    ?>

    <hr class="hr-line"/>

</div>
