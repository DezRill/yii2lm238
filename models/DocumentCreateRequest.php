<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 22.04.2021
 * Time: 11:51
 */

namespace app\models;


use yii\base\Model;

class DocumentCreateRequest extends Model
{
    public $date;
    public $senderTown;
    public $senderDepartment;
    public $serviceType;
    public $phone;
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
                    'senderTown',
                    'senderDepartment',
                    'serviceType',
                    'phone',
                    'firstName',
                    'secondName',
                    'recipientTown',
                    'description',
                    'cargoType',
                    'cost'
                ],
                'required', 'message' => 'Поля должны быть заполнены'
            ],
            [
                [
                    'date',
                    'senderTown',
                    'senderDepartment',
                    'serviceType',
                    'phone',
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


    public function sendData()
    {

    }
}