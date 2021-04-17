<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 10:37
 */

namespace app\models\document\request;


class DocumentCreateRequest extends DocumentBigOnesBasic
{
    public $serviceType;        // Значение из справочника Технология доставки
    public $description;        // Текстовое поле, вводится для доп. описания
    public $sender;             // Идентификатор отправителя
    public $contactSender;      // Идентификатор контактного лица отправителя
    public $sendersPhone;       // Телефон отправителя в формате: +380660000000, 380660000000, 0660000000
    public $recipient;          // Идентификатор получателя
    public $contactRecipient;   // Идентификатор контактного лица получателя
    public $recipientsPhone;    // Телефон получателя в формате: +380660000000, 80660000000, 0660000000
    public $x;                  // Дирина, в см
    public $y;                  // Длина, в см            //Объёмный вес по формуле (длина*ширина*высота)/4000
    public $z;                  // Высота, в см

    public function rules()
    {
        return [
            [['serviceType', 'description', 'sender', 'contactSender', 'senderPhone', 'recipient',
                'contactRecipient', 'recipientPhone'], 'required', 'message' => 'Поле не должно быть пустым'],
            [['x', 'y', 'z'], 'type' => 'double', 'message' => 'Только числа'],
            [['description'], 'string', 'max' => 50],
        ];
    }
}