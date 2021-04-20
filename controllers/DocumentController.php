<?php

namespace app\controllers;

use app\models\Cabinet;
use app\models\document\request\DocumentCreateRequest;
use app\models\document\request\DocumentListRequest;
use yii\data\ArrayDataProvider;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DocumentController extends Controller
{
    public function actionIndex($id)
    {
        $cabinet = Cabinet::findOne($id);

        if (empty($cabinet)) {
            throw new NotFoundHttpException();
        }

        $getDocumentsList = new DocumentListRequest();
        $getDocumentsList->apiKey = $cabinet->api_key;
        return $this->render('index', ['getDocumentsList' => $getDocumentsList, 'cabinet' => $cabinet]);
    }

    public function actionView()
    {

    }

    public function actionCreate($id)
    {
        $cabinet = Cabinet::findOne($id);

        if (empty($cabinet)) {
            throw new NotFoundHttpException();
        }

        $createDocument = new DocumentCreateRequest([
            'dateTime' => date('d.m.Y'),
            'apiKey' => $cabinet->api_key,
            'citySender' => $cabinet->town,
            'senderAddress' => $cabinet->dispatch_dep,
            'sender' => $cabinet->counterparty,
            'contactSender' => $cabinet->contact_person,
            'sendersPhone' => '+' . getPhone($cabinet->api_key, $cabinet->counterparty),
        ]);

        return $this->render('create', ['createDocument' => $createDocument, 'cabinet' => $cabinet]);
    }

    public function actionUpdate()
    {

    }

    public function actionDelete($apiKey, $ref)
    {
        $client = new Client();

        $delete = $client->createRequest()
            ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $apiKey,
                'modelName' => 'InternetDocument',
                'calledMethod' => 'delete',
                'methodProperties' => [
                    'DocumentRefs' => $ref
                ]
            ])->send();

        return $this->redirect(['index', 'apiKey' => $apiKey]);
    }

    public function actionGetData()
    {
        $model = new DocumentListRequest();

        if ($model->load(\Yii::$app->request->post())) {

            if ($model->validate()) {

                $items = $model->getDocuments();

                $dataProvider = new ArrayDataProvider([
                    'allModels' => $items,
                    'pagination' => false,
                ]);

                return $this->renderAjax('grid', [
                    'dataProvider' => $dataProvider,
                    'api' => $model->apiKey,
                ]);

            } else {
                return $this->asJson([
                    'success' => false,
                    'errors' => $model->getErrors()
                ]);
            }
        }
    }

    public function actionSendData()
    {
        $model = new DocumentCreateRequest();

        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $response = $model->sendData();
            if ($response['success'])
            {

            }
            debug($response);
        }
    }
}