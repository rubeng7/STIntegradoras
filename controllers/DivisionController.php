<?php

namespace app\controllers;

use Yii;
use app\models\Division;
use app\models\SearchDivision;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DivisionController implements the CRUD actions for Division model.
 */
class DivisionController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all Division models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchDivision();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Division model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Division model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Division();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDivision]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Division model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idDivision]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Division model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $division = $this->findModel($id);
        if (count($division->carreras) > 0) {
            // Hay carreras en esta division!!
            \app\models\Utilerias::setFlash('div-del-1', 'No se puede eliminar'
                    . ' esta división debido a que tiene <b>CARRERAS</b> asociadas', 'Problemas al eliminar', 5000);
        } elseif (count($division->personas) > 0) {
            // Hay personas en esta division
            \app\models\Utilerias::setFlash('div-del-2', 'No se puede eliminar'
                    . ' esta división debido a que hay <b>PERSONAS</b> relacionadas a ella', 'Problemas al eliminar', 5000);
        } else {
            $division->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Division model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Division the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Division::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
