<?php

namespace app\controllers;

use app\models\Document;
use app\widgets\Alert;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class DocumentController extends Controller
{
    public function actionIndex($apiKey)
    {
        $model = new Document();
        return $this->render('index', compact('model'));
    }

    public function actionView()
    {

    }

    public function actionCreate()
    {

    }

    public function actionUpdate()
    {

    }

    public function actionDelete()
    {

    }
}