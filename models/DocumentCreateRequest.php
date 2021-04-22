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
    public $weight;
    public $length;
    public $width;
    public $height;
    public $seatsAmount;
    public $cost;
    public $description;
    public $backwardRedeliveryMoney;
    public $payerType;

}