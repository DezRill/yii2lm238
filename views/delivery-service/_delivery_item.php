<?php
/** @var $model \app\models\DeliveryService
 * @var $this \yii\web\View
 */

$css = <<<CSS
.image_icon.active {opacity: 1; border: 4px solid black; padding: 1px}
CSS;
$this->registerCss($css);
?>

<?= $this->beginBody() ?>
    <div class="post-container">
        <div class="post-thumb">
            <?= \yii\helpers\Html::img($model->icon, ['class' => 'image_icon']) ?>
        </div>
        <div class="post-content">
            <a href="<?php echo \yii\helpers\Url::to(['/delivery-service/view', 'id' => $model->id]) ?>">
                <h3 class="post-title"><?php echo \yii\helpers\Html::encode($model->name) ?></h3>
            </a>
            <h4><b><?php echo \yii\helpers\Html::encode($model->short_name) ?></b></h4>
        </div>
    </div>
<?= $this->endBody() ?>