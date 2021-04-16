<?php

namespace app\models;

use yii\base\Model;

class DocumentSearch extends Model
{
    public $dateFrom;
    public $dateTo;

    public function rules()
    {
        return [
            [['dateFrom', 'dateTo'], 'required'],
            [['dateFrom', 'dateTo'], 'data', 'format' => 'dd.mm.yyyy'],
            [['dateTo'], 'compare', 'compareAttribute' => 'dateFrom', 'operator' => '>=']
        ];
    }
}