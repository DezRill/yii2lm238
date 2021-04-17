<?php
/**
 * @var $dataProvider \yii\data\ArrayDataProvider
 */

use yii\widgets\ListView;

?>
<?= ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_document_item',
]);
?>
