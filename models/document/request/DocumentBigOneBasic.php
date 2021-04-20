<?php

namespace app\models\document\request;

class DocumentBigOneBasic extends DocumentBasic
{
    public $apiKey;
    public $payerType;          // Значение из справочника Тип плательщика
    public $paymentMethod;      // Значение из справочника Тип оплаты
    public $dateTime;           // Дата отправки в формате дд.мм.гггг
    public $cargoType;          // Значение из справочника Тип груза
    public $weight;             // min - 0,1 Вес фактический, кг
    public $seatsAmount;        // Целое число, количество мест отправления
    public $cost;               // Целое число, объявленная стоимость
    public $citySender;         // Идентификатор города отправителя
    public $senderAddress;      // Идентификатор адреса отправителя
    public $sendersPhone;       // Номер телефона отправителя
    public $cityRecipient;      // Идентификатор города получателя
    public $recipientAddress;   // Идентификатор адреса получателя
    public $recipientsPhone;    // Номер телефона получателя
}