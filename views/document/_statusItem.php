<?php
/* @var $model app\models\DocumentStatusHistory */
?>

<div class="item">
    <div class="datetime">
        <b>
            <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?><br/>
            <?= $model->time ?>
        </b>
    </div>
    <div class="status">
        <table>
            <tr>
                <td>
                    <b><?= $model->status ?></b>
                </td>
            </tr>
        </table>
    </div>
</div>
<hr class="hr-line" />
