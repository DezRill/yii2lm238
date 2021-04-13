<?php

namespace app\controllers;

use Yii;
use app\models\Cabinet;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CabinetController implements the CRUD actions for Cabinet model.
 */
class CabinetController extends Controller
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

    /**
     * Creates a new Cabinet model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cabinet();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['delivery-service/view?id=1']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cabinet model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['delivery-service/view?id=1']);
        }

        $apiData=$this->getDatabyAPI('5427c06765bdcbd4da909b4c0bd86d5e');

        return $this->render('update', [
            'model' => $model,
            'counterparties' => $apiData['counterparties']->data['data'],
            'contactPersons' => $apiData['contactPersons']->data['data'],
            'towns' => $apiData['towns']->data['data'],
            'departments' => $apiData['departments']->data['data'],
        ]);
    }

    /**
     * Deletes an existing Cabinet model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['delivery-service/view?id=1']);
    }

    /**
     * Finds the Cabinet model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cabinet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
*/
    protected function findModel($id)
    {
        if (($model = Cabinet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    private function getDatabyAPI($key)
    {
        $client=new Client();

        $counterparties = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $key,
                'modelName' => 'Counterparty',
                'calledMethod' => 'getCounterparties',
                'methodProperties' => ['CounterpartyProperty' => 'Sender'],
            ])->send();

        $contactPersons = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $key,
                'modelName' => 'Counterparty',
                'calledMethod' => 'getCounterpartyContactPersons',
                'methodProperties' => ['Ref' => ArrayHelper::getValue($counterparties->data, 'data.0.Ref')],
            ])->send();

        $towns = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $key,
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getSettlements',
                'methodProperties' => ['Warehouse' => 1, 'Page' => 41],
            ])->send();

        $departments = $client->createRequest()
            ->setFormat(Client::FORMAT_JSON)
            ->setUrl('https://api.novaposhta.ua/v2.0/json/')
            ->setData([
                'apiKey' => $key,
                'modelName' => 'AddressGeneral',
                'calledMethod' => 'getWarehouses',
                //'methodProperties' => ['CityRef' => ArrayHelper::getValue($towns->data, 'data.0.Ref')],
                //'methodProperties' => ['CityName' => 'Хмельницький'],
                'methodProperties' => ['CityRef' => 'db5c88ac-391c-11dd-90d9-001a92567626'],
            ])->send();

        if ($counterparties->isOk && $contactPersons->isOk)
            return [
                'counterparties' => $counterparties,
                'contactPersons' => $contactPersons,
                'towns' => $towns,
                'departments' => $departments,
        ];
        else throw new NotFoundHttpException('Ошибка при загрузке страницы');
    }
}
