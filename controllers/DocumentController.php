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
use yii\helpers\ArrayHelper;
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
            'sender' => $cabinet->counterparty,
            'senderTown' => $cabinet->town,
            'senderDepartment' => $cabinet->dispatch_dep,
            'contactSender' => $cabinet->contact_person,
            'sendersPhone' => getPhone($cabinet->api_key, $cabinet->counterparty),
            'serviceType' => 'WarehouseDoors',
            'cargoType' => 'Cargo',
            'redelivery' => 0,
        ]);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->validate()) {
                $model->seatsAmount = count($model->seatParams);

                if ($model->sendData($cabinet->api_key, $cabinet->id)) {
                    $newDocument = Document::findOne(Document::find()->max('id'));

                    Yii::$app->session->setFlash('success', '<span class="glyphicon glyphicon-ok-sign"></span>Накладная <b>№' . $newDocument->document_num . '</b> успешно создана.');

                    return $this->redirect(['update', 'id' => $newDocument->id]);
                } else {
                    Yii::$app->session->setFlash('danger', '<span class="glyphicon glyphicon-remove-sign"></span> Ошибка при создании накладной. Пожалуйста, проверьте корректность данных.');
                }
            } else {
                Yii::$app->session->setFlash('danger', 'Ошибка при заполнении данных. Пожалуйста, попробуйте ещё раз.');
                $this->refresh();
            }
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
        Yii::$app->session->setFlash('warning', '<span class="glyphicon glyphicon-info-sign"></span> Накладная удалена.');

        return $this->redirect(['index', 'id' => $c_id]);
    }

    public function actionMassiveDelete()
    {
        $ids = Yii::$app->request->post('ids');
        if (!empty($ids)) {
            $model = Document::findOne($ids[0]);
            foreach ($ids as $id) {
                $model = $this->findModel($id);
                $model->delete();
                Yii::$app->session->setFlash('warning', '<span class="glyphicon glyphicon-info-sign"></span> Накладные удалены.');
                return $this->renderAjax('_messages');
            }
            return $this->redirect(['index', 'id' => $model->cabinet_id]);
        }
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
            }
        }
    }

    public function actionRenderNotification($result)
    {
        switch ($result){
            case 0:
                Yii::$app->session->setFlash('success', '<span class="glyphicon glyphicon-ok-sign"></span> Данные успешно обновлены.');
                return $this->renderAjax('_messages');
            break;
            case 1:
                Yii::$app->session->setFlash('danger', '<span class="glyphicon glyphicon-remove-sign"></span>Ошибка обновления данных. Пожалуйста, попробуйте ещё раз.');
                return $this->renderAjax('_messages');
            break;
        }

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

    public function actionAddCargo()
    {
        $key = Yii::$app->request->post('key');

        return $this->renderPartial('create-parts/_cargo', ['key' => $key]);
    }
}
