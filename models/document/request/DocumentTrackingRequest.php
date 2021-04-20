<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 20.04.2021
 * Time: 17:02
 */

namespace app\models\document\request;


use yii\httpclient\Client;

class DocumentTrackingRequest extends DocumentBasic
{
    public $documentNumber;
    public $phone;

    public function rules()
    {
        return [
            [['apiKey', 'documentNumber', 'phone'], 'required', 'message' => 'Поле не должно быть пустым']
        ];
    }

    public function getDocuments()
    {
        $client = new Client();

        $documents = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $this->apiKey,
                'modelName' => 'TrackingDocument',
                'calledMethod' => 'getStatusDocument',
                'methodProperties' => [
                    [
                        'DocumentNumber' => '20450376523172',
                        'Phone' => '380970951279'
                    ],
                    [
                        'DocumentNumber' => '20450376429647',
                        'Phone' => '380970951279'
                    ]
                ]
            ])->send();

        return $documents->data;
    }
}