<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 17.04.2021
 * Time: 10:37
 */

namespace app\models\document\request;


use yii\httpclient\Client;

class DocumentCreateRequest extends DocumentBasic
{
    public $sender;
    public $contactSender;
    public $sendersPhone;
    public $serviceType;        // Значение из справочника Технология доставки
    public $description;        // Текстовое поле, вводится для доп. описания
    public $recipient;          // Идентификатор получателя
    public $contactRecipient;   // Идентификатор контактного лица получателя
    public $recipientsPhone;    // Телефон получателя в формате: +380660000000, 80660000000, 0660000000
    public $volumetricWidth;    // Дирина, в см
    public $volumetricLength;   // Длина, в см            //Объёмный вес по формуле (длина*ширина*высота)/4000
    public $volumetricHeight;   // Высота, в см

    public function rules()
    {
        return [
            [
                [
                    'apiKey',
                    'payerType',
                    'paymentMethod',
                    'dateTime',
                    'cargoType',
                    'weight',
                    'seatsAmount',
                    'cost',
                    'recipientPhone',
                    'cityRecipient',
                    'recipientAddress',
                    'serviceType', 'description',
                    'recipient',
                    'contactRecipient',
                    'recipientPhone',
                    'volumetricWidth',
                    'volumetricLength',
                    'volumetricHeight',
                    'sender',
                    'contactSender',
                    'sendersPhone',
                ],
                'required',
                'message' => 'Поле не должно быть пустым'
            ],
            [['volumetricWidth', 'volumetricLength', 'volumetricHeight', 'weight'], 'double', 'message' => 'Только числа'],
            [['seatsAmount', 'cost'], 'integer', 'message' => 'Только целые числа'],
            [['description'], 'string', 'max' => 50],
        ];
    }

    public function sendData()
    {
        $client = new Client();

        $sendData = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $this->apiKey,
                'modelName' => 'InternetDocument',
                'calledMethod' => 'save',
                'methodProperties' => [
                    'PayerType' => $this->payerType,
                    'PaymentMethod' => $this->paymentMethod,
                    'DateTime' => $this->dateTime,
                    'CargoType' => $this->cargoType,
                    'OptionsSeat' => [
                        'volumetricWidth' => $this->volumetricWidth,
                        'volumetricLength' => $this->volumetricLength,
                        'volumetricHeight' => $this->volumetricHeight
                    ],
                    'Weight' => $this->weight,
                    'ServiceType' => $this->serviceType,
                    'SeatsAmount' => $this->seatsAmount,
                    'Description' => $this->description,
                    'Cost' => $this->cost,
                    'CitySender' => $this->citySender,
                    'Sender' => $this->sender,
                    'SenderAddress' => $this->senderAddress,
                    'ContactSender' => $this->contactSender,
                    'SendersPhone' => $this->sendersPhone,
                    'CityRecipient' => $this->cityRecipient,
                    'Recipient' => $this->recipient,
                    'RecipientAddress' => $this->recipientAddress,
                    'ContactRecipient' => $this->contactRecipient,
                    'RecipientsPhone' => $this->recipientsPhone
                ]
            ])->send();

        debug($sendData->data);
    }
}