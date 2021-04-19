<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 10:50
 */

namespace app\models\document\response;


class DocumentListResponse extends DocumentBigOnesBasic
{
    public $ref;                        // Идентификатор ЭН
    public $prefferedDeliveryDate;      // Желаемая дата доставки
    public $intDocNumber;               // Номер интернет документа
    public $costOnSite;                 // Стоимость за доставку
    public $afterpaymentOnGoodsCost;    // Обратная доставка
    public $packingNumber;              // Номер упаковки
    public $rejectionReason;            // Описание причины неразвоза
    public $citySenderDescription;
    public $senderAddressDescription;
    public $cityRecipientDescription;
    public $recipientAddressDescription;
}