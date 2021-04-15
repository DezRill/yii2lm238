<?php

use yii\helpers\Html;

/**
 * @var $this \yii\web\View
 * @var $model \app\models\DeliveryService
 */

$js = <<<JS
    $(document).on('click','.image_icon', function() {
       var image = $(this);
       var modal_window = $('#modal-window');
       var input = $('#deliveryservice-icon');
       modal_window.modal('hide');
       input.val(image.attr("src"));
       image.addClass('active');
       image.siblings('.active').removeClass('active');
    });
JS;
$this->registerJs($js, $this::POS_END);

$css = <<<CSS
.image_icon {
    margin: 20px 20px 20px 20px;
    border: none;
    color: white;
    text-align: center;
    font-size: 16px;
    opacity: 0.6;
    transition: 0.3s;
}

.image_icon.active {opacity: 1; border: 4px solid black; }

.image_icon:hover {opacity: 1;}
CSS;
$this->registerCss($css);
$this->registerCssFile("@web/css/item/css", ['depends' => 'yii\web\YiiAsset']);
?>

<?= Html::img('@web/images/plane.png', ['class' => 'image_icon' . (('/web/images/plane.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/ship.png', ['class' => 'image_icon' . (('/web/images/ship.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/truck.png', ['class' => 'image_icon' . (('/web/images/truck.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/box.png', ['class' => 'image_icon' . (('/web/images/box.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/courier.png', ['class' => 'image_icon' . (('/web/images/courier.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/intime.png', ['class' => 'image_icon' . (('/web/images/intime.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/meest.png', ['class' => 'image_icon' . (('/web/images/meest.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>
<?= Html::img('@web/images/ukrposhta.png', ['class' => 'image_icon' . (('/web/images/ukrposhta.png' == $model->icon) ? " active" : ""), 'role' => 'button']); ?>