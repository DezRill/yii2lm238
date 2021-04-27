<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;

class DocumentDownloadModel extends Model
{
    public $apiKey;
    public $dateFrom;
    public $dateTo;

    public function rules()
    {
        return [
            [['apiKey', 'dateFrom', 'dateTo'], 'required', 'message' => 'Поле не должно быть пустым'],
            [['dateFrom', 'dateTo'], 'date', 'format' => 'dd.mm.yyyy'],
            [['dateTo'], 'compare', 'compareAttribute' => 'dateFrom', 'operator' => '>='],
            ['apiKey', 'exist', 'targetAttribute' => 'api_key', 'targetClass' => Cabinet::class]
        ];
    }

    public function downloadDocuments($id)
    {
        $client = new Client();

        $request = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $this->apiKey,
                'modelName' => 'InternetDocument',
                'calledMethod' => 'getDocumentList',
                'methodProperties' => [
                    'DateTimeFrom' => $this->dateFrom,
                    'DateTimeTo' => $this->dateTo,
                    'GetFullList' => 1
                ]
            ])->send();

        if ($request->data['success']) {
            $count = 0;
            foreach ($request->data['data'] as $document) {
                if (!Document::find()->where(['document_num' => $document['IntDocNumber']])->exists()) {

                    $newDocument = new Document();

                    $newDocument->cabinet_id = $id;
                    $newDocument->document_num = $document['IntDocNumber'];
                    $newDocument->document_ref=$document['Ref'];

                    $dateTime = explode(' ', $document['CreateTime']);

                    $newDocument->date = $dateTime[0];
                    $newDocument->time = $dateTime[1];

                    $newDocument->current_status = $newDocument->convertCodeStatus($document['StateId']);

                    $newDocument->save();

                    $count++;
                }
            }
            if ($count === 0) {
                Yii::$app->session->setFlash('warning', '<span class="glyphicon glyphicon-info-sign"></span> На указанном промежутке нет накладных для загрузки');
            }
            else {
                Yii::$app->session->setFlash('success', '<span class="glyphicon glyphicon-ok-sign"></span> Запрос успешно выполнен. Загружено накладных: <b>' . $count . '</b>');
            }
        } else {
            Yii::$app->session->setFlash('danger', '<span class="glyphicon glyphicon-remove-sign"></span> Ошибка загрузки данных. Пожалуйста, попробуйте ещё раз.');
        }
    }
}