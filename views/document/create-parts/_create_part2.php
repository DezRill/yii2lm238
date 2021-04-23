<?php

use kartik\slider\Slider;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DocumentCreateRequest */
/* @var $form yii\widgets\ActiveForm */
/* @var $cabinet app\models\Cabinet */

$tabs = <<<CSS
.cargo-header {
text-align: center;
font-size: 16px;
height: 36px;
line-height: 36px;
margin: 10px 0 10px 0;
}

.cargo-element {
margin: 30px 150px 10px 150px;
font-size: 16px;
background-color: #f2f2f2;
padding: 20px;
}

.removeElement {
float: right;
border: none;
background: inherit;
}

#w1-slider {
width: 60%;
margin-top: 30px;
}

.element-slider {
text-align: center;
margin-bottom: 15px;
}

.element-slider label {
font-weight: 200;
}

#documentWeight {
color: red;
font-weight: 700;
}

#sendWeight {
color: red;
font-weight: 700;
}

.element-footer-right {
float: right;
}

.element-footer-right label {
font-weight: 200;
}

.cargo-element-weight {
float: right;
width: 9%;
border: none;
background-color: inherit;
text-align: right;
}

#addPlace {
margin-left: 40%;
margin-right: 40%;
margin-top: 20px;
color: red;
font-size: 14px;
font-weight: 900;
background-color: inherit;
border: none;
}
CSS;
$this->registerCss($tabs);

$this->registerJsVar('posts', 0, $this::POS_HEAD);

$sendJs = <<<JS
function (val) {
  
  switch (val)
  {
      case 1:
          {
              $('#sendWeight').text('до 0.5 кг');
              $('#sizes').text('15x12x11');
              var items=$('#sizes').text().split('x');
              $('#weight').val('0.5');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '0.5';
          }
      break;
      case 2:
          {
              $('#sendWeight').text('до 1 кг');
              $('#sizes').text('26x14x11');
              var items=$('#sizes').text().split('x');
              $('#weight').val('1');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '1';
          }
      break;
      case 3:
          {
              $('#sendWeight').text('до 2 кг');
              $('#sizes').text('33x22x11');
              var items=$('#sizes').text().split('x');
              $('#weight').val('2');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '2';
          }
      break;
      case 4:
          {
              $('#sendWeight').text('до 5 кг');
              $('#sizes').text('40x25x20');
              var items=$('#sizes').text().split('x');
              $('#weight').val('5');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '5';
          }
      break;
      case 5:
          {
              $('#sendWeight').text('до 10 кг');
              $('#sizes').text('42x34x28');
              var items=$('#sizes').text().split('x');
              $('#weight').val('10');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '10';
          }
      break;
      case 6:
          {
              $('#sendWeight').text('до 20 кг');
              $('#sizes').text('50x40x40');
              var items=$('#sizes').text().split('x');
              $('#weight').val('20');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '20'
          }
      break;
      case 7:
          {
              $('#sendWeight').text('до 30 кг');
              $('#sizes').text('68x43x41');
              var items=$('#sizes').text().split('x');
              $('#weight').val('30');
              $('.cargo-element-length').val(items[0]);
              $('.cargo-element-width').val(items[1]);
              $('.cargo-element-height').val(items[2]);
              $('.overweight').addClass('hidden');
              return '30'
          }
      break;
      case 8:
          {
              $('#sendWeight').text('больше 30 кг');
              $('#sizes').text('Обязательно');
              $('.cargo-element-weight').val('30');
              $('.cargo-element-length').val('');
              $('.cargo-element-width').val('');
              $('.cargo-element-height').val('');
              $('.overweight').removeClass('hidden');
              return '30+';
          }
      break;
  }
}
JS;

$documentsJs = <<<JS
function (val) {
  switch (val)
  {
      case 1:
          {
              $('#documentWeight').text('до 0.5 кг');
              $('#weightToWrite').text('0.5');
              return '0.5';
          }
      break;
      case 2:
          {
              $('#documentWeight').text('до 1 кг');
              $('#weightToWrite').text('1');
              return '1';
          }
      break;
  }
}
JS;


$mainJs = <<<JS
$(document).on('click', '#sizes', function() {
  $('#sizesDataModal').modal('show');
});

$('#addPlace').on('click', function() {
  var cargo_list = $('.cargo-list');
  var new_cargo_element = $('#cargoElement').clone();
  
  posts++;
  
  $('.removeElement').removeClass('hidden');
  
  new_cargo_element.find('.placeNum').text('Место №'+(posts+1));
  //var new_slider = new_cargo_element.find('.slider');
  //$('.cargo-list').find(new_slider).attr('name', 'DocumentCreateRequest[seatParams]['+posts+'][weight]');
  
  new_cargo_element.find('.cargo-element-length').attr('name','DocumentCreateRequest[seatParams]['+posts+'][length]');
  new_cargo_element.find('.cargo-element-width').attr('name','DocumentCreateRequest[seatParams]['+posts+'][width]');
  new_cargo_element.find('.cargo-element-height').attr('name','DocumentCreateRequest[seatParams]['+posts+'][height]');
  new_cargo_element.find('.cargo-element-weight').attr('name','DocumentCreateRequest[seatParams]['+posts+'][weight]');
  
  cargo_list.append(new_cargo_element);
  
  new_cargo_element.find('.removeElement').removeClass('hidden');
});

$(document).on('click', '.removeElement', function() {
  var remove_button  = $(this);
  var confirm=window.confirm('Вы уверены, что хотите удалить место?');
  if (confirm === true)
  {
      remove_button.closest('.cargo-element').remove();
      posts--;
      var places = $('.cargo-list').find('.placeNum');
      
      for (var i=0;i<places.length;i++)
      {
          $('.cargo-list').find(places[i]).text('Место №'+(i+1));
      }
      
      if (posts===0) $(document).find('.removeElement').addClass('hidden');
  }
  //$(el).attr('name','DocumentCreateRequest[seatParams]['+posts+'][weight]')
})
JS;
$this->registerJs($mainJs);

?>

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
                <div class="cargo-element" id="cargoElement">
                    <div class="element-header">
                        <b><?= Html::label('Место № 1', '', ['class' => 'placeNum']) ?></b>
                        <?= Html::button('<span class="glyphicon glyphicon-remove"></span>', ['class' => 'removeElement hidden']) ?>
                    </div>
                    <div class="element-slider">
                        <?= Html::label('Вес посылки: ') ?>
                        <?= Html::label('до 0.5 кг', null, ['id' => 'sendWeight', 'class' => 'labelWeight']) ?><br/>
                        <?= Slider::widget([
                            'name' => 'sliderOptionsSend',
                            'sliderColor' => Slider::TYPE_DANGER,
                            'handleColor' => Slider::TYPE_DANGER,
                            'pluginOptions' => [
                                'min' => 1,
                                'max' => 8,
                                'step' => 1,
                                'ticks' => [1, 2, 3, 4, 5, 6, 7, 8],
                                'formatter' => new \yii\web\JsExpression($sendJs),
                            ]
                        ]) ?>

                        <?= Html::input('text', 'DocumentCreateRequest[seatParams][0][length]', '', ['class' => ' hidden']) ?>
                        <?= Html::input('text', 'DocumentCreateRequest[seatParams][0][width]', '', ['class' => ' hidden']) ?>
                        <?= Html::input('text', 'DocumentCreateRequest[seatParams][0][height]', '', ['class' => ' hidden']) ?>

                    </div>
                    <div class="element-footer">
                        <div class="overweight hidden">
                            <b><?= Html::label('Фактический вес, кг') ?></b>
                            <?= Html::input('text', 'DocumentCreateRequest[seatParams][0][weight]', '', ['class' => 'cargo-element-weight']) ?>
                        </div>
                        <b><?= Html::label('Габариты') ?></b>
                        <div class="element-footer-right">
                            <?= Html::label('15x12x11', null, ['id' => 'sizes']) ?> <span
                                    class="glyphicon glyphicon-resize-full"></span>
                        </div>
                    </div>

                    <?php
                    /*\yii\bootstrap\Modal::begin([
                        'id' => 'sizesDataModal',
                        'header' => '<h2>Габариты</h2>'
                    ]);
                    echo $this->render('_part2_sizesModal', ['model' => $model, 'form' => $form]);
                    \yii\bootstrap\Modal::end()
                    */ ?>
                </div>
            </div>
            <b><?= Html::button('<span class="glyphicon glyphicon-plus-sign"> ДОБАВИТЬ МЕСТО</span>', ['id' => 'addPlace']) ?></b>
        </div>
        <div class="tab-pane" id="documents-type-tab">
            <div class="cargo-element element-slider">
                <?= Html::label('Вес посылки: ') ?>
                <b><?= Html::label('до 0.5 кг', null, ['id' => 'documentWeight']) ?></b><br/>
                <?= Slider::widget([
                    'id' => 'documents',
                    'name' => 'sliderOptionsDocuments',
                    'sliderColor' => Slider::TYPE_DANGER,
                    'handleColor' => Slider::TYPE_DANGER,
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

