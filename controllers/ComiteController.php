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
use app\models\ComiteProfesor;


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
     * 
     * @param Comite $model
     * @param ComiteProfesor $comiteProfesoresOrignal
     * @return boolean
     */
    private function registrar($model, $comiteProfesoresOriginal) {

        // Creación de un arreglo de ComiteProfesores segun el formulario.
        $comiteProfesores = Model::createMultiple(ComiteProfesor::className());

        // Carga multiple de los datos para los objetos de la variable anterior
        Model::loadMultiple($comiteProfesores, \Yii::$app->request->post());

        // Inicio de una transacción
        $transaccion = Yii::$app->db->beginTransaction();

        if (!$model->isNewRecord) {
            // Esta editando
            // Colocando el id del comité a los objetos ComiteProfesor
            foreach ($comiteProfesores as $cp) {
                $cp->idComite = $model->idComite;
            }

            // Obtención de los registros que estan en la base de datos pero no en el formulario.
            $comiteProfesoresOld = array_udiff($comiteProfesoresOriginal, $comiteProfesores, ['app\models\ComiteProfesor', 'compare']);

            // Obtención de los nuevos registros a añadir a la base de datos.
            $comiteProfesores = array_udiff($comiteProfesores, $comiteProfesoresOriginal, ['app\models\ComiteProfesor', 'compare']);

            // Eliminación de registros duplicados en el array
            $comiteProfesores = \app\models\Utilerias::my_array_unique($comiteProfesores);

            // Eliminación de la base de datos de registros viejos
            ComiteProfesor::eliminarMultiple($comiteProfesoresOld);
        } else {
            // Eliminación de registros duplicados en el array
            $comiteProfesores = \app\models\Utilerias::my_array_unique($comiteProfesores);
        }

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

        // Definir si los datos son validos
        if ($valid) {
            // Registrar objetos en la base de datos
            if ($model->registrar($comiteProfesores, false)) {
                // hacer comit y retornar true
                $transaccion->commit();
                return true;
            } else {
                /*
                 * Hacer rollback y retornar false (Los mensajes de alerta ya 
                 * fueron lanzados internamente)
                 */
                $transaccion->rollBack();
                return false;
            }
        }
    }

    /**
     * Creates a new Comite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        
        // Creación de variables necesarias para la creación
        $model = new Comite();
        $comiteProfesores = [new \app\models\ComiteProfesor()];

        // Condición para detectar si se debe realizar un guardado
        if ($model->load(Yii::$app->request->post())) {
            
            if ($this->registrar($model, $comiteProfesores)) {
                return $this->redirect(['view', 'id' => $model->idComite]);
            }
        }
        
        /*
         * Si llega aquí significa que solo esta desplegando el formulario
         * o que ocurrio un error
         */

        // Renderizado de la vista
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
        
        // Obtención de variables necesarias para la creación
        $model = $this->findModel($id);
        $comiteProfesores = $model->comiteProfesors;

        // Condición para detectar si se debe realizar un guardado
        if ($model->load(Yii::$app->request->post())) {
            
            if ($this->registrar($model, $comiteProfesores)) {
                return $this->redirect(['view', 'id' => $model->idComite]);
            }
        }
        
        /*
         * Si llega aquí significa que solo esta desplegando el formulario
         * o que ocurrió un error
         */

        // Renderizado de la vista
        return $this->render('update', [
                    'model' => $model,
                    'comiteProfesores' => $comiteProfesores
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
