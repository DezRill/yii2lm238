<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.04.2021
 * Time: 11:51
 */

namespace app\models;


use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

class DocumentCreateRequest extends Model
{
    public $date;
    public $sender;
    public $senderTown;
    public $contactSender;
    public $senderDepartment;
    public $sendersPhone;
    public $serviceType;
    public $recipientsPhone;
    public $firstName;
    public $secondName;
    public $lastName;
    public $recipientTown;
    public $recipientDepartment;
    public $street;
    public $house;
    public $flat;
    public $cargoType;
    public $seatParams;
    public $seatsAmount;
    public $cost;
    public $description;
    public $payerType;
    public $redelivery;
    public $redeliveryValue;
    public $redeliveryPayer;


    public function rules()
    {
        return [
            [
                [
                    'date',
                    'sender',
                    'senderTown',
                    'senderDepartment',
                    'sendersPhone',
                    'serviceType',
                    'recipientsPhone',
                    'firstName',
                    'secondName',
                    'recipientTown',
                    'description',
                    'cargoType',
                    'cost',
                    'payerType',
                    'seatsAmount'
                ],
                'required', 'message' => 'Поля должны быть заполнены'
            ],
            [
                [
                    'date',
                    'sender',
                    'senderTown',
                    'senderDepartment',
                    'sendersPhone',
                    'serviceType',
                    'recipientsPhone',
                    'firstName',
                    'secondName',
                    'lastName',
                    'recipientTown',
                    'recipientDepartment',
                    'street',
                    'description',
                    'cargoType',
                    'payerType',
                    'redelivery',
                    'redeliveryPayer',
                ],
                'string'
            ],
            [
                [
                    'house',
                    'flat',
                    'cost',
                    'redeliveryValue',
                    'seatsAmount',
                ],
                'integer', 'message' => 'Только целые числа'
            ],
            [['seatParams'], 'safe'],
            [['seatParams'], 'seatValidation'],
        ];
    }


    public function seatValidation($attr)
    {
        foreach ($this->$attr as $item) {
            if (empty($item['weight']) || empty($item['length']) || empty($item['width']) || empty($item['height'])) {
                $this->addError($attr, 'Поля должны быть заполнены');
            }
        }
    }


    public function sendData($apiKey, $id)
    {
        $client = new Client();
        $request = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/');

        if ($this->serviceType == 'WarehouseWarehouse') {
            if ($this->cargoType == 'Cargo') {
                if ($this->redelivery == 0) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'OptionsSeat' => $this->seatParams,
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => '1',
                            'RecipientHouse' => '',
                            'RecipientFlat' => '',
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date
                        ]
                    ]);
                } else if ($this->redelivery == 1) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'OptionsSeat' => $this->seatParams,
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => '1',
                            'RecipientHouse' => '',
                            'RecipientFlat' => '',
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date,
                            'BackwardDeliveryData' => [
                                'PayerType' => $this->redeliveryPayer,
                                'CargoType' => 'Money',
                                'RedeliveryString' => $this->redeliveryValue
                            ]
                        ]
                    ]);
                }
            } else if ($this->cargoType == 'Documents') {
                if ($this->redelivery == 0) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'Weight' => ArrayHelper::getValue($this->seatParams, '0.weight'),
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => '1',
                            'RecipientHouse' => '',
                            'RecipientFlat' => '',
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date
                        ]
                    ]);
                } else if ($this->redelivery == 1) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'Weight' => ArrayHelper::getValue($this->seatParams, '0.weight'),
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => '1',
                            'RecipientHouse' => '',
                            'RecipientFlat' => '',
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date,
                            'BackwardDeliveryData' => [
                                'PayerType' => $this->redeliveryPayer,
                                'CargoType' => 'Money',
                                'RedeliveryString' => $this->redeliveryValue
                            ]
                        ]
                    ]);
                }
            }
        } else if ($this->serviceType == 'WarehouseDoors') {
            if ($this->cargoType == 'Cargo') {
                if ($this->redelivery == 0) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'OptionsSeat' => $this->seatParams,
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => $this->street,
                            'RecipientHouse' => $this->house,
                            'RecipientFlat' => $this->flat,
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date
                        ]
                    ]);
                } else if ($this->redelivery == 1) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'OptionsSeat' => $this->seatParams,
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => $this->street,
                            'RecipientHouse' => $this->house,
                            'RecipientFlat' => $this->flat,
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date,
                            'BackwardDeliveryData' => [
                                'PayerType' => $this->redeliveryPayer,
                                'CargoType' => 'Money',
                                'RedeliveryString' => $this->redeliveryValue
                            ]
                        ]
                    ]);
                }
            } else if ($this->cargoType == 'Documents') {
                if ($this->redelivery == 0) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'Weight' => ArrayHelper::getValue($this->seatParams, '0.weight'),
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => $this->street,
                            'RecipientHouse' => $this->house,
                            'RecipientFlat' => $this->flat,
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date
                        ]
                    ]);
                } else if ($this->redelivery == 1) {
                    $request->setData([
                        'apiKey' => $apiKey,
                        'modelName' => 'InternetDocument',
                        'calledMethod' => 'save',
                        'methodProperties' => [
                            'NewAddress' => '1',
                            'PayerType' => $this->payerType,
                            'PaymentMethod' => 'Cash',
                            'CargoType' => $this->cargoType,
                            'Weight' => ArrayHelper::getValue($this->seatParams, '0.weight'),
                            'ServiceType' => $this->serviceType,
                            'SeatsAmount' => $this->seatsAmount,
                            'Description' => $this->description,
                            'Cost' => $this->cost,
                            'CitySender' => $this->senderTown,
                            'Sender' => $this->sender,
                            'SenderAddress' => $this->senderDepartment,
                            'ContactSender' => $this->contactSender,
                            'SendersPhone' => $this->sendersPhone,
                            'RecipientCityName' => townRefToDescription($this->recipientTown, $apiKey),
                            'RecipientArea' => '',
                            'RecipientAreaRegions' => '',
                            'RecipientAddressName' => $this->street,
                            'RecipientHouse' => $this->house,
                            'RecipientFlat' => $this->flat,
                            'RecipientName' => $this->firstName . ' ' . $this->secondName . ' ' . $this->lastName,
                            'RecipientType' => 'PrivatePerson',
                            'RecipientsPhone' => $this->recipientsPhone,
                            'DateTime' => $this->date,
                            'BackwardDeliveryData' => [
                                'PayerType' => $this->redeliveryPayer,
                                'CargoType' => 'Money',
                                'RedeliveryString' => $this->redeliveryValue
                            ]
                        ]
                    ]);
                }
            }
        }

        $request = $request->send();

        if ($request->data['success'])
        {
            $model=new Document();
            $model->cabinet_id=$id;
            $model->document_num=ArrayHelper::getValue($request->data, 'data.0.IntDocNumber');
            $model->date=date('Ymd');
            $model->time=date('His');
            $model->current_status=1;
            $model->save();
        }
    }
}