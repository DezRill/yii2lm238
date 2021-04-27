<?php

namespace app\models;

use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property int $cabinet_id
 * @property string $document_num
 * @property string $document_ref
 * @property string $date
 * @property string $time
 * @property int $current_status
 * @property string|null $description
 *
 * @property DocumenStatusHistory[] $documenStatusHistories
 * @property Cabinet $cabinet
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cabinet_id', 'document_num', 'document_ref', 'date', 'time', 'current_status'], 'required', 'message' => 'Поле не должно быть пустым'],
            [['cabinet_id', 'current_status'], 'integer'],
            [['date', 'time'], 'safe'],
            [['description'], 'string'],
            [['document_num', 'document_ref'], 'string', 'max' => 55],
            [['cabinet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cabinet::className(), 'targetAttribute' => ['cabinet_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cabinet_id' => 'Cabinet ID',
            'document_num' => 'Document Num',
            'document_ref' => 'Document Ref',
            'date' => 'Date',
            'time' => 'Time',
            'current_status' => 'Current Status',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[DocumenStatusHistories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDocumenStatusHistories()
    {
        return $this->hasMany(DocumenStatusHistory::className(), ['document_id' => 'id']);
    }

    /**
     * Gets query for [[Cabinet]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCabinet()
    {
        return $this->hasOne(Cabinet::className(), ['id' => 'cabinet_id']);
    }

    public function updateStatus($apiKey)
    {
        $client = new Client();

        $document = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $apiKey,
                'modelName' => 'TrackingDocument',
                'calledMethod' => 'getStatusDocuments',
                'methodProperties' => [
                    'Documents' => [
                        [
                            'DocumentNumber' => $this->document_num,
                            'Phone' => ''
                        ]
                    ]
                ]
            ])->send();

        $code = ArrayHelper::getValue($document->data, 'data.0.StatusCode');
        $message=ArrayHelper::getValue($document->data, 'data.0.Status');

        $writeHistory=new DocumentStatusHistory();
        $writeHistory->document_id=$this->id;
        $writeHistory->date=date('Y-m-d');
        $writeHistory->time=date('H:i:s');
        $writeHistory->status=$message;
        $writeHistory->save();

        return $this->convertCodeStatus($code);
    }

    public function deleteOnServer($apiKey, $ref)
    {
        $client = new Client();

        $delete = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $apiKey,
                'modelName' => 'InternetDocument',
                'calledMethod' => 'delete',
                'methodProperties' => [
                    'DocumentRefs' => $ref
                ]
            ])->send();

        return $delete->data['success'];
    }

    public function convertCodeStatus($code)
    {
        switch ($code)
        {
            case 1: return 1; break;
            case 10:
            case 11:
            case 106:
            case 9: return 2; break;
            case 4:
            case 41:
            case 5:
            case 6:
            case 7:
            case 8:
            case 12:
            case 101:
            case 104:
            case 111:
            case 112: return 3; break;
            case 2:
            case 3:
            case 102:
            case 103:
            case 108:
            case 105: return 4; break;
        }
    }
}
