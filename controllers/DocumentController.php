<?php

namespace app\controllers;

use app\models\document\request\DocumentCreateRequest;
use app\models\document\request\DocumentListRequest;
use yii\data\ArrayDataProvider;
use yii\httpclient\Client;
use yii\web\Controller;

class DocumentController extends Controller
{
    public function actionIndex($apiKey)
    {
        $getDocumentsList = new DocumentListRequest();
        $getDocumentsList->apiKey = $apiKey;
        return $this->render('index', ['getDocumentsList' => $getDocumentsList]);
    }

    public function actionView()
    {

    }

    public function actionCreate($apiKey)
    {
        $createDocument = new DocumentCreateRequest();
        $createDocument->apiKey = $apiKey;
        return $this->render('create', ['createDocument' => $createDocument]);
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

        if ($model->load(\Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->sendData();
            }
        }
    }
}