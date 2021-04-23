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
    public $seatParams = [
        0 => [
            'weight' => 'value',
            'length' => 'value1',
            'width' => 'value2',
            'height' => 'value3',
        ],
    ];
//    public $weight;
//    public $length;
//    public $width;
//    public $height;
    public $seatsAmount;
    public $cost;
    public $description;
    public $backwardRedeliveryMoney;
    public $payerType;


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
                    'lastName',
                    'recipientTown',
                    'recipientDepartment',
                    'street',
                    'house',
                    'flat',
                    'cargoType',
                ],
                'string'
            ],
            [['seatParams'], 'safe'],
            [['seatParams'], 'seatValidation'],
        ];
    }


    public function seatValidation($attr)
    {
        foreach ($this->$attr as $item){
            if(empty($item['weight']) || empty($item['length']) || empty($item['width']) || empty($item['height'])){
                $this->addError($attr,'asasasasdsdasdas');
            }
        }
    }


    public function sendData(){

    }
}