<?php

namespace app\controllers;

use Yii;
use app\models\Carrera;
use app\models\SearchCarrera;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarreraController implements the CRUD actions for Carrera model.
 */
class CarreraController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Carrera models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCarrera();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Carrera model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Carrera model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Carrera();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCarrera]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Carrera model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idCarrera]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Carrera model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $carrera = $this->findModel($id);
        if(count($carrera->grupos) > 0) {
            // Hay grupos en esta carrera!!
            \app\models\Utilerias::setFlash('car-del-1', 'No se puede eliminar '
                    . 'esta carrera debido a que tiene <b>GRUPOS</b> relacionados', 'Problemas al eliminar', 5000);
        } elseif(count($carrera->esquemas) > 0) {
            \app\models\Utilerias::setFlash('car-del-2', 'No se puede eliminar '
                    . 'esta carrera debido a que tiene <b>ESQUEMAS</b> relacionados', 'Problemas al eliminar', 5000);
        } else {
            $carrera->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Carrera model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Carrera the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Carrera::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
