<?php

namespace app\models\document\request;


class DocumentBigOnesBasic extends DocumentBasic
{
    public $payerType;          // Значение из справочника Тип плательщика
    public $paymentMethod;      // Значение из справочника Тип оплаты
    public $dateTime;           // Дата отправки в формате дд.мм.гггг
    public $cargoType;          // Значение из справочника Тип груза
    public $weight;             // min - 0,1 Вес фактический, кг
    public $seatsAmount;        // Целое число, количество мест отправления
    public $cost;               // Целое число, объявленная стоимость
    public $citySender;         // Идентификатор города отправителя
    public $senderAddress;      // Идентификатор адреса отправителя
    public $cityRecipient;      // Идентификатор города получателя
    public $recipientAddress;   // Идентификатор адреса получателя
    public $senderPhone;        // Номер телефона отправителя
    public $recipientPhone;     // Номер телефона получателя
}