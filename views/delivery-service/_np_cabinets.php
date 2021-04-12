<?php
/** @var $model \app\models\Cabinet */
?>

<div class="post-container">
    <div class="post-content">
        <a href="<?= \yii\helpers\Url::to(['/delivery-service/cabinet/update', 'id' => $model->id]) ?>">
            <h3 class="post-title"><?= \yii\helpers\Html::encode($model->name) ?></h3>
        </a>
    </div>
</div>