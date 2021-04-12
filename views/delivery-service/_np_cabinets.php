<?php
/** @var $model \app\models\Cabinet */
?>

<div class="post-container">
    <div class="post-thumb">
        <?= \yii\helpers\Html::img('/web/images/cabinet_logo.png') ?>
    </div>
    <div class="post-content">
        <a href="<?= \yii\helpers\Url::to(['/cabinet/update', 'id' => $model->id]) ?>">
            <h3 class="post-title" style="margin-top: 35px"><?= \yii\helpers\Html::encode($model->name) ?></h3>
        </a>
    </div>
</div>