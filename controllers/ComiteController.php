<?php

namespace app\controllers;

use Yii;
use app\models\Comite;
use app\models\SearchComite;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Periodo;
use app\models\Utilerias;
use app\models\Model;

/**
 * ComiteController implements the CRUD actions for Comite model.
 */
class ComiteController extends Controller {

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
     * Lists all Comite models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchComite();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionSelect() {

        $searchModel = new SearchComite();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('indexModal', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Comite model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }
    
    
    public function actionViewModal($id) {
        if ($id == 0) {
            echo $this->renderAjax('viewModal', [
                        'model' => $id,
                        'tipo' => 1
            ]);
        } else {
            echo $this->renderAjax('viewModal', [
                        'model' => $this->findModel($id),
                        'tipo' => 2
            ]);
        }
    }

    public function actionGetDatos($id) {
        $comite = Comite::findOne($id);
        
        return $comite->nombre . ' Para: ' . Utilerias::getPeriodo($comite->idPeriodo0);
    }

    /**
     * Creates a new Comite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Comite();
        
        $comiteProfesores = [new \app\models\ComiteProfesor()];

        if ($model->load(Yii::$app->request->post())) {
            
            $comiteProfesores = Model::createMultiple(\app\models\ComiteProfesor::className());
            Model::loadMultiple($comiteProfesores, \Yii::$app->request->post());
            
            //validacion ajax
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return \yii\helpers\ArrayHelper::merge(
                                ActiveForm::validateMultiple($comiteProfesores), ActiveForm::validate($model)
                );
            }

            // validacion php
            $valid = $model->validate();
            $valid = Model::validateMultiple($comiteProfesores) && $valid;

            if ($valid) {
                if($model->registrar($comiteProfesores, false)) {
                    return $this->redirect(['view', 'id' => $model->idComite]);
                }
            } else {
                Utilerias::setFlash('com-reg-1', 'Ocurrió un error de validación. Revisa el formulario', 'Problema de validación', 5000);
            }
        }
        
        return $this->render('create', [
                    'model' => $model,
                    'comiteProfesores' => $comiteProfesores
        ]);
    }

    /**
     * Updates an existing Comite model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $periodo = $model->idPeriodo0;

        if ($model->load(Yii::$app->request->post()) && $periodo->load(Yii::$app->request->post())) {
            $this->registrar($model, $periodo);
        }
        return $this->render('update', [
                    'model' => $model,
                    'periodo' => $periodo
        ]);
    }

    /**
     * Deletes an existing Comite model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Comite model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Comite the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Comite::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
