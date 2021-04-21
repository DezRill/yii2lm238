<?php

use yii\helpers\Html;

/** @var $model \app\models\Document
 * @var $cabinet app\models\Cabinet
 */
?>

<hr class="hr-line"/>
<div class="post-container">
    <div class="document-menu">
        <p><?= Html::a('<span class="glyphicon glyphicon-pencil"> Открыть</span>', ['update', 'id' => $model->id], ['class' => 'btn btn-success btn-item']) ?></p>
        <p><?= Html::a('<span class="glyphicon glyphicon-trash"> Удалить</span>', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger btn-item',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить накладную?',
                    'method' => 'post',
                ],
            ]) ?></p>
        <p><?= Html::a('<span class="glyphicon glyphicon-repeat"> Обновить статус</span>', ['update-status', 'id' => $model->id], [
                'class' => 'btn btn-primary btn-item load-status',
                'data-target'=>"#status_".$model->id
            ]) ?></p>
    </div>
    <div class="post-title">
        Декларация доставки
    </div>
    <div class="document-thumb">
        <? switch ($model->current_status) {
            case 1:
                $text = "Оформление";
                $class = "formalized";
                break;
            case 2:
                $text = "Отправлено";
                $class = "sent";
                break;
            case 3:
                $text = "Доставлено";
                $class = "delivered";
                break;
            case 4:
                $text = "Отказ";
                $class = "failure";
                break;
            default:
                $text = "";
                $class = "";
                break;
        }?>
        <div class="<?=$class?>" id="status_<?=$model->id?>"><b><?=$text?></b></div>
    </div>
    <div class="document-content">
        <p><b>№ <?= $model->document_num ?></b></p>
        <p><b><span class="glyphicon glyphicon-calendar"></span> <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?></p></b>
        <p><b><span class="glyphicon glyphicon-time"></span> <?= $model->time ?></p></b>
    </div>
</div>
