<?php use kartik\slider\Slider;
use yii\web\View; ?>

<?php
$js = <<<JS
function (val) {
  
  switch (val)
  {
      case 1:
          {
              $('#sendWeight').text('до 0.5 кг');
              $('.sizes').text('15x12x11');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('0.5');
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
              $('.sizes').text('26x14x11');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('1');
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
              $('.sizes').text('33x22x11');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('2');
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
              $('.sizes').text('40x25x20');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('5');
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
              $('.sizes').text('42x34x28');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('10');
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
              $('.sizes').text('50x40x40');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('20');
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
              $('.sizes').text('68x43x41');
              var items=$('.sizes').text().split('x');
              $('.cargo-element-weight').val('30');
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
              $('.sizes').text('Обязательно');
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
?>

<?= Slider::widget([
    'name' => 'sliderOptionsSend',
    'sliderColor' => Slider::TYPE_DANGER,
    'handleColor' => Slider::TYPE_DANGER,
    'hashVarLoadPosition' => View::POS_READY,
    'pluginOptions' => [
        'min' => 1,
        'max' => 8,
        'step' => 1,
        'reserved' => true,
        'ticks' => [1, 2, 3, 4, 5, 6, 7, 8],
        'formatter' => new \yii\web\JsExpression($js),
    ]
])?>
