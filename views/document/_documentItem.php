<?php

use yii\helpers\Html;

/** @var $model \app\models\Document
 * @var $cabinet app\models\Cabinet
 */
?>

<hr class="hr-line"/>
<div class="post-container">
    <div class="document-menu">
        <div class="dropDown">
            <?= \yii\bootstrap\ButtonDropdown::widget([
                'encodeLabel' => false,
                'label' => '<span class="glyphicon glyphicon-menu-hamburger"></span>',
                'dropdown' => [
                    'items' => [
                        ['label' => Html::a('<span class="glyphicon glyphicon-pencil"></span> Открыть', ['update', 'id' => $model->id]), 'encode' => false],
                        ['label' => Html::a('<span class="glyphicon glyphicon-trash"></span> Удалить', ['delete', 'id' => $model->id], [
                            'data' => [
                                'confirm' => 'Вы уверены, что хотите удалить накладную?',
                                'method' => 'post',
                            ],
                        ]), 'encode' => false],
                        ['label' => Html::a('<span class="glyphicon glyphicon-repeat"></span> Обновить статус', ['update-status', 'id' => $model->id], [
                            'class' => 'load-status',
                            'data-target' => "#status_" . $model->id
                        ]), 'encode' => false],
                        ['label' => Html::a('<span class="glyphicon glyphicon-print"></span> Печать', 'https://my.novaposhta.ua/orders/printDocument/orders[]/' . $model->document_num . '/type/pdf/apiKey/' . $cabinet->api_key, ['target' => '_blank']), 'encode' => false],
                    ],
                ],
                'options' => [
                    'style' => 'background-color:inherit;',
                ],
            ]) ?>
        </div>
    </div>
    <div class="post-title">
        Декларация доставки
    </div>
    <div class="check-item-action">
        <input type="checkbox" class="form-check-input" , href="/document/update-status?id=<?= $model->id ?>"
               data-target="#status_<?= $model->id ?>">
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
                $text = "ERROR";
                $class = "failure";
                break;
        } ?>
        <div class="<?= $class ?>" id="status_<?= $model->id ?>"><b><?= $text ?></b></div>
    </div>
    <div class="document-content">
        <p><b>№ <?= $model->document_num ?></b></p>
        <p>
            <b><span class="glyphicon glyphicon-calendar"></span> <?= Yii::$app->formatter->asDate($model->date, 'php:d.m.Y') ?>
        </p></b>
        <p><b><span class="glyphicon glyphicon-time"></span> <?= $model->time ?></p></b>
    </div>
</div>
