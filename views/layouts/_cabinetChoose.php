<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */

$choose = <<<JS
$(document).on('click', '#acceptButton', function() {
 $('#modalWindow').modal("hide");
  var value = $('#cabinetValue').val();
  
  window.location.href='/document/index?id='+value;
})
JS;
$this->registerJs($choose);

?>

<div class="choose-cabinet" align="center">
    <p>
        <?= Html::dropDownList('id', null, ArrayHelper::map($model, 'id', 'name'), ['class' => 'form-control', 'id' => 'cabinetValue']); ?>
    </p>
    <p>
        <?= Html::button('Применить', ['class' => 'btn btn-success', 'id' => 'acceptButton']); ?>
    </p>
</div>
