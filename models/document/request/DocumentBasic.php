<?php

namespace app\models\document\request;

use yii\base\Model;

class DocumentBasic extends Model
{
    public $apiKey;             // Ключ

    public function rules()
    {
        return [
            [['apiKey'], 'required'],
        ];
    }
}