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

        return $this->render('update', ['model' => $model]);
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
}
