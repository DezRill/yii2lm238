<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "delivery_service".
 *
 * @property int $id
 * @property string $name
 * @property string $short_name
 * @property resource $icon
 * @property string $http_url
 * @property string $as_default
 */
class DeliveryService extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public $uploadedFile;

    public static function tableName()
    {
        return 'delivery_service';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'short_name', 'http_url', 'icon'], 'required'],
            [['icon', 'as_default'], 'string'],
            [['name', 'short_name', 'http_url'], 'string', 'max' => 55],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'short_name' => 'Короткое название',
            'icon' => 'Иконка',
            'http_url' => 'Http Url',
            'as_default' => 'По умолчанию',
        ];
    }

    public function beforeSave($insert)
    {
       // if ($this->as_default==1){
            DeliveryService::updateAll(['as_default' => 0], 'as_default = 1');
        //}
        return parent::beforeSave($insert);
    }
}
