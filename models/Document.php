<?php

namespace app\models;


use yii\base\Model;

class Document extends Model
{
    public $apiKey;             // Ключ
    public $payerType;          // Значение из справочника Тип плательщика
    public $paymentMethod;      // Значение из справочника Тип оплаты
    public $dateTime;           // Дата отправки в формате дд.мм.гггг
    public $cargoType;          // Значение из справочника Тип груза
//    public $volumeGeneral;      // Объем общий, м.куб (min - 0.0004), обязательно для заполнения, если не указаны значения OptionsSeat
    public $x;                  // Дирина, в см
    public $y;                  // Длина, в см            //Объёмный вес по формуле (длина*ширина*высота)/4000
    public $z;                  // Высота, в см
    public $weight;             // min - 0,1 Вес фактический, кго
    public $serviceType;        // Значение из справочника Технология доставки
    public $seatsAmount;        // Целое число, количество мест отправления
    public $description;        // Текстовое поле, вводится для доп. описания
    public $cost;               // Целое число, объявленная стоимость
    public $citySender;         // Идентификатор города отправителя
    public $sender;             // Идентификатор отправителя
    public $senderAddress;      // Идентификатор адреса отправителя
    public $contactSender;      // Идентификатор контактного лица отправителя
    public $senderPhone;        // Телефон отправителя в формате: +380660000000, 380660000000, 0660000000
    public $cityRecipient;      // Идентификатор города получателя
    public $recipient;          // Идентификатор получателя
    public $recipientAddress;   // Идентификатор адреса получателя
    public $contactRecipient;   // Идентификатор контактного лица получателя
    public $recipientPhone;     // Телефон получателя в формате: +380660000000, 80660000000, 0660000000

    public function rules()
    {
        return [
            [['payerType', 'paymentMethod', 'dateTime', 'cargoType', 'x', 'y', 'z', 'weight', 'serviceType', 'seatsAmount', 'description', 'cost', 'citySender', 'sender',
                'senderAddress', 'contactSender', 'senderPhone', 'cityRecipient', 'recipient', 'recipientAddress', 'contactRecipient', 'recipientPhone'], 'required', 'message' => 'Поле не должно быть пустым'],
            [['x', 'y', 'z', 'weight'], 'type' => 'double', 'message' => 'Только числа'],
            [['seatsAmount', 'cost'], 'integer', 'message' => 'Только целые числа'],
            [['description'], 'string', 'max' => 255],
        ];
    }
}