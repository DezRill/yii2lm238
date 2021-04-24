<?php

use yii\helpers\Html;

/**
 * @var integer $key
 */

?>

<div class="cargo-element" id="cargoElement">
    <div class="element-header">
        <b><?= Html::label('Место № ' . ($key + 1), '', ['class' => 'placeNum']) ?></b>
        <?= Html::button('<span class="glyphicon glyphicon-remove"></span>', ['class' => 'removeElement hidden']) ?>
    </div>
    <div class="element-slider">
        <?= Html::label('Вес посылки: ') ?>
        <?= Html::label('до 0.5 кг', null, ['id' => 'sendWeight', 'class' => 'labelWeight']) ?><br/>
        <div class="slider-div">
            <input type="text" class="form-control" name="sliderOptionsSend" data-value="1" value="1" style="display: none;">
        </div>
        <?= Html::input('text', 'DocumentCreateRequest[seatParams][' . ($key) . '][volumetricLength]', '', ['class' => 'cargo-element-length hidden']) ?>
        <?= Html::input('text', 'DocumentCreateRequest[seatParams][' . ($key) . '][volumetricWidth]', '', ['class' => 'cargo-element-width hidden']) ?>
        <?= Html::input('text', 'DocumentCreateRequest[seatParams][' . ($key) . '][volumetricHeight]', '', ['class' => 'cargo-element-height hidden']) ?>

    </div>
    <div class="element-footer">
        <div class="overweight hidden">
            <b><?= Html::label('Фактический вес, кг') ?></b>
            <?= Html::input('text', 'DocumentCreateRequest[seatParams][' . $key . '][weight]', '', ['class' => 'cargo-element-weight']) ?>
        </div>
        <b><?= Html::label('Габариты') ?></b>
        <div class="element-footer-right">
            <?= Html::label('15x12x11', null, ['class' => 'sizes']) ?> <span
                    class="glyphicon glyphicon-resize-full"></span>
        </div>
    </div>
</div>