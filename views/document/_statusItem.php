<?php
/* @var $model app\models\DocumentStatusHistory */
?>

<div class="item">
    <div class="datetime">
        <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?><br/>
        <?= $model->time ?>
    </div>
    <div class="status">
        <table>
            <tr>
                <td>
                    <?= $model->status ?>
                </td>
            </tr>
        </table>
    </div>
</div>
