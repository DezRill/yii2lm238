<?php

namespace app\controllers;

use app\models\Cabinet;
use app\models\DocumentCreateRequest;
use app\models\DocumentStatusHistory;
use kartik\slider\Slider;
use Yii;
use app\models\Document;
use app\models\DocumentSearch;
use yii\base\ErrorException;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DocumentController implements the CRUD actions for Document model.
 */
class DocumentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($id)
    {
        $cabinet = Cabinet::findOne($id);

        if (empty($cabinet)) throw new NotFoundHttpException('Ошибка загрузки данных');
        $searchModel = new DocumentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cabinet' => $cabinet,
        ]);
    }

    /**
     * Creates a new Document model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $cabinet = Cabinet::findOne($id);

        $model = new DocumentCreateRequest([
            'date' => date('d.m.Y'),
            'senderTown' => $cabinet->town,
            'senderDepartment' => $cabinet->dispatch_dep,
            'serviceType' => 'WarehouseDoors',
            'cargoType' => 'Cargo',
            'redelivery' => 0,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

//            $model->sendData();
            echo '<pre>' . print_r($model) . '</pre>';
            exit();
//            return $this->redirect(['index', 'id' => $cabinet->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'cabinet' => $cabinet,
        ]);
    }

    /**
     * Updates an existing Document model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $cabinet = Cabinet::findOne($model->cabinet_id);

        $messages = DocumentStatusHistory::find()->where(['document_id' => $model->id])->all();
        $messagesProvider = new ArrayDataProvider([
            'allModels' => $messages,
            'pagination' => false
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $cabinet->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'cabinet' => $cabinet,
            'messages' => $messagesProvider,
        ]);
    }

    /**
     * Deletes an existing Document model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $c_id = $model->cabinet_id;
        $model->delete();

        return $this->redirect(['index', 'id' => $c_id]);
    }

    public function actionUpdateStatus($id)
    {
        $model = $this->findModel($id);
        if (!empty($cabinet = Cabinet::findOne($model->cabinet_id))) {
            try {
                $model->current_status = $model->updateStatus($cabinet->api_key);
                $model->save();
                return $this->asJson(['state' => $model->current_status]);
            } catch (ErrorException $e) {
                throw new NotFoundHttpException('Ошибка загрузки данных');
            }
        }
    }

    public function actionSetSlider()
    {
        return $this->renderAjax('create-parts/_slider');
    }

    /**
     * Finds the Document model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Document the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Document::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Страница не существует.');
    }
}
