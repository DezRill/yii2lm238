<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DocumentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cabinet app\models\Cabinet */

$this->title = 'Накладные';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile("@web/css/item.css");
$this->registerCssFile("@web/css/document_item.css");


$js = <<<JS
$(document).on('click','.load-status',function(e) {
  e.preventDefault();
  var _this = $(this),
      url =_this.attr('href');
      status_selector = _this.data('target');
      status_element = $(document).find(status_selector);
      
   if(!status_element.length){
       return true;
   }
   
   $.get(url,{}, function(response) {
        status_element.removeAttr('class');
        var text_block =status_element.children('b');
        text_block.text('');
        
     switch (response.state){
         case 1:
                status_element.addClass('formalized');
                text_block.text('Оформление');
            break;
         case 2:
             status_element.addClass('sent');
             text_block.text('Отправлено');
            break;
         case 3:
             status_element.addClass('delivered');
             text_block.text('Доставлено');
            break;
         case 4:
             status_element.addClass('failure');
             text_block.text('Отказ');
            break;
     }
   });
})
JS;
$this->registerJs($js, $this::POS_END);
?>
<div class="document-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать накладную', ['create', 'id' => $cabinet->id], ['class' => 'btn btn-success']) ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_documentItem',
        'summary' => '',
    ])
    ?>

    <hr class="hr-line"/>

</div>
