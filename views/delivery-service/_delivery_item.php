<?php
/** @var $model \app\models\DeliveryService */
?>

<div class="post-container">
    <div class="post-thumb">
        <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($model->icon ).'"/>'; ?>
    </div>
    <div class="post-content">
        <a href="<?php echo \yii\helpers\Url::to(['/delivery-service/view', 'id' => $model->id]) ?>">
            <h3 class="post-title"><?php echo \yii\helpers\Html::encode($model->name) ?></h3>
        </a>
        <h4><b><?php echo \yii\helpers\Html::encode($model->short_name)?></b></h4>
    </div>
</div>