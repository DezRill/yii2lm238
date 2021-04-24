<?php

use kartik\slider\Slider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$documentsJs = <<<JS
function (val) {
  switch (val)
  {
      case 1:
          {
              $('#documentWeight').text('до 0.5 кг');
              $('.cargo-element-weight').val('0.5');
              return '0.5';
          }
      break;
      case 2:
          {
              $('#documentWeight').text('до 1 кг');
              $('.cargo-element-weight').val('1');
              return '1';
          }
      break;
  }
}
JS;
?>
<?= Html::input('text', 'DocumentCreateRequest[cargoType]', 'Cargo', ['class' => 'cargo-element-type hidden']) ?>
<?= Html::input('text', 'DocumentCreateRequest[seatsAmount]', '1', ['class' => 'cargo-element-seats-amount hidden']) ?>

<div class="cargo-header"><b>Тип груза</b></div>

<div class="part2-tabs">
    <ul class="nav nav-pills">
        <li class="nav-item active" id="cargo-type-send">
            <a class="nav-link" data-toggle="tab" href="#send-type-tab"><span
                        class="glyphicon glyphicon-briefcase"></span> Посылка</a>
        </li>
        <li class="nav-item" id="cargo-type-documents">
            <a class="nav-link" data-toggle="tab" href="#documents-type-tab"><span
                        class="glyphicon glyphicon-duplicate"></span> Документы</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="send-type-tab">
            <div class="cargo-list">
                <?= $this->render('_cargo', ['key' => 0]) ?>
            </div>
            <div class="addPlace">
                <b><?= Html::button('<span class="glyphicon glyphicon-plus-sign"> ДОБАВИТЬ МЕСТО</span>', ['id' => 'addPlace']) ?></b>
            </div>

        </div>
        <div class="tab-pane" id="documents-type-tab">
            <div class="cargo-element element-slider">
                <?= Html::label('Вес посылки: ') ?>
                <b><?= Html::label('до 0.5 кг', null, ['id' => 'documentWeight']) ?></b><br/>
                <?= Slider::widget([
                    'id' => 'documents',
                    'name' => 'sliderOptionsDocuments',
                    'sliderColor' => '#FF0000',
                    'handleColor' => '#FF0000',
                    'pluginOptions' => [
                        'min' => 1,
                        'max' => 2,
                        'step' => 1,
                        'ticks' => [1, 2],
                        'formatter' => new \yii\web\JsExpression($documentsJs),
                    ]
                ]) ?>
            </div>
        </div>
    </div>
</div>

