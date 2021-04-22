<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */

$this->title = 'Создание накладной';
$this->params['breadcrumbs'][] = ['label' => 'Накладные', 'url' => ['index', 'id' => $cabinet->id]];
$this->params['breadcrumbs'][] = $this->title;

$css = <<< CSS
.nav-pills {
    text-align:center;
}

.nav-pills > li {
    float:none;
    display:inline-block;
    zoom:1;
}
CSS;
$this->registerCss($css);

?>
<div class="document-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="nav nav-pills">
        <li class="nav-item active">
            <a data-toggle="tab" href="#information"><span class="glyphicon glyphicon-file"></span> Информация</a>
        </li>
        <li id="parcel_tab" class="nav-item">
            <a data-toggle="tab" href="#parcel"> <span class="glyphicon glyphicon-envelope"></span> Посылка</a>
        </li>
        <li class="nav-item">
            <a data-toggle="tab" href="#payment"> <span class="glyphicon glyphicon-usd"></span> Оплата</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="information">
            <?= $this->render('create-parts/_create_part1', ['model' => $model, 'cabinet' => $cabinet]) ?>
        </div>
        <div class="tab-pane" id="parcel">
        </div>
        <div class="tab-pane" id="payment">
        </div>
    </div>
</div>
