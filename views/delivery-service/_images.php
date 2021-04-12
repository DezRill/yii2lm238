<?php
use yii\helpers\Html;
?>

<?= Html::img('@web/images/plane.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/ship.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/truck.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/box.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/courier.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/intime.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/meest.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>
<?= Html::img('@web/images/ukrposhta.png', ['class' => 'image_icon', 'onclick' => 'icourl(this)']); ?>

<style>
    .image_icon {
        margin: 20px 20px 20px 20px;
        border: none;
        color: white;
        text-align: center;
        font-size: 16px;
        opacity: 0.6;
        transition: 0.3s;
    }
    .image_icon:hover {opacity: 1;}
</style>

<script>
    icourl=function (image) {
        alert(image.getAttribute("src"));
    }
</script>