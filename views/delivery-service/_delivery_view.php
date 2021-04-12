<?php
/** @var $model \app\models\DeliveryService */
?>

<div class="post-container">
    <div class="post-thumb">
        <?= \yii\helpers\Html::img($model->icon) ?>
    </div>
    <div class="post-content">
        <h4><b>Название:</b> <?php echo \yii\helpers\Html::encode($model->name) ?></h4>
        <h4><b>Короткое название:</b> <?php echo \yii\helpers\Html::encode($model->short_name) ?></h4>
        <h4><b>http адрес для проверки деклараций:</b> <?php echo \yii\helpers\Html::encode($model->http_url) ?></h4>
    </div>
</div>