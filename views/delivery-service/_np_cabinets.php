<?php
/** @var $model \app\models\Cabinet */

$css = <<<CSS
.image_icon:hover {
border: 4px solid black;
transition: 0.3s;
}
.image_icon.active {opacity: 1; border: 4px solid black; padding: 1px}
CSS;
$this->registerCss($css);

$this->registerJsFile('@web/js/jQueryCookies.js', ['depends' => 'yii\web\YiiAsset']);
$this->registerCssFile('@web/css/item.css');

$js = <<<JS
$(document).on('click', '.image_icon', function() {
  var new_default=$(this);
  if ($.cookie('default_service')!=null)
      {
          var old_default=$('#'+$.cookie('default_cabinet'));
          old_default.removeClass('active');
      }
  new_default.addClass('active');
  $.cookie('default_cabinet', new_default.attr("id")    , {expires: 30});
});

$(document).ready(function() {
    if ($.cookie('default_service')!=null) $('#'+$.cookie('default_cabinet')).addClass('active');
})
JS;
$this->registerJs($js)
?>

<div class="post-container">
    <div class="post-thumb">
        <?= \yii\helpers\Html::img('/web/images/cabinet_logo.png', ['class' => 'image_icon', 'role' => 'button', 'id' => $model->id]) ?>
    </div>
    <div class="post-content">
        <a href="<?= \yii\helpers\Url::to(['/cabinet/update', 'id' => $model->id]) ?>">
            <h3 class="post-title" style="margin-top: 35px"><?= \yii\helpers\Html::encode($model->name) ?></h3>
        </a>
    </div>
</div>