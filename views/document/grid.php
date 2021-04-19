<?php
/**
 * @var $dataProvider \yii\data\ArrayDataProvider
 */

use yii\grid\GridView;
use yii\helpers\Html;

?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'label' => 'Номер накладной',
            'attribute' => 'intDocNumber',
        ],
        [
            'label' => 'Дата создания',
            'attribute' => 'dateTime',
            'format' => ['date', 'php: d.m.Y H:i:s'],
        ],
        [
            'label' => 'Ориентировочная дата доставки',
            'attribute' => 'prefferedDeliveryDate',
        ],
        [
            'label' => 'Вес',
            'attribute' => 'weight',
        ],
        [
            'label' => 'Количество мест',
            'attribute' => 'seatsAmount',
        ],
        [
            'label' => 'Объявленная стоимость',
            'attribute' => 'cost',
        ],
        [
            'label' => 'Город отправителя',
            'attribute' => 'citySenderDescription',
        ],
        [
            'label' => 'Город получателя',
            'attribute' => 'cityRecipientDescription',
        ],
        [
            'label' => 'Адрес отправителя',
            'attribute' => 'senderAddressDescription',
        ],
        [
            'label' => 'Адрес получателя',
            'attribute' => 'recipientAddressDescription',
        ],
        [
            'label' => 'Стоимость доставки',
            'attribute' => 'costOnSite',
        ],
        [
            'label' => 'Плательщик',
            'attribute' => 'payerType',
        ],
        [
            'label' => 'Тип оплаты',
            'attribute' => 'paymentMethod',
        ],

        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view}{update}{delete}',
            'buttons' => [
                'delete' => function ($url, $model) use ($api) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'apiKey' => $api, 'ref' => $model['ref']], [
                        'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить накладную?',
                            'method' => 'post',
                        ],
                    ]);
                }
            ],
        ],
    ]
]);

?>
