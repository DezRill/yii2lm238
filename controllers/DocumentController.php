<?php

namespace app\controllers;

use app\models\document\request\DocumentCreateRequest;
use app\models\document\request\DocumentListRequest;
use app\models\document\response\DocumentListResponse;
use yii\data\ArrayDataProvider;
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
        $createDocument=new DocumentCreateRequest();
        $createDocument->apiKey=$apiKey;
        return $this->render('create', ['createDocument' => $createDocument]);
    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }

    public function actionGetData()
    {

        $model = new DocumentListRequest();

        $model->load(\Yii::$app->request->post(), '');

        if ($model->validate()) {

            $items = $model->getDocuments($model->apiKey, $model->dateFrom, $model->dateTo);

            debug($items);

            $dataProvider = new ArrayDataProvider([
                'allModels'=>$items,
                'pagination'=>false,
            ]);

            return $this->renderAjax('grid',[
                'dataProvider'=>$dataProvider
            ]);

        } else {
            return $this->asJson([
                'success' => false,
                'errors' => $model->getErrors()
            ]);
        }

    }
}