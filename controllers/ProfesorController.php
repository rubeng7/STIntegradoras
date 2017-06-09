<?php

namespace app\controllers;

use Yii;
use app\models\Profesor;
use app\models\SearchProfesor;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Persona;
use app\models\Usuario;
use app\models\Model;
use app\models\ProfesorGrupoPeriodo;
use app\models\Utilerias;

/**
 * ProfesorController implements the CRUD actions for Profesor model.
 */
class ProfesorController extends Controller {

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
     * Lists all Profesor models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchProfesor();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSelect() {
        $searchModel = new SearchProfesor();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('indexModal', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profesor model.
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
        $profesor = Profesor::findOne($id);
        return $profesor->nivelEstudios . ' ' . $profesor->idProfesor0->idUsuario0->toString();
    }

    /**
     * Creates a new Profesor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {

        // Creación de variables necesarias para la creación
        $model = new Profesor();
        $persona = new Persona();
        $usuario = new Usuario();
        $profesorGrupoPeriodos = [new ProfesorGrupoPeriodo()];

        // Condición para detectar si se debe realizar un guardado
        if ($model->load(Yii::$app->request->post()) &&
                $persona->load(Yii::$app->request->post()) &&
                $usuario->load(Yii::$app->request->post())) {

            if ($this->registrar($model, $persona, $usuario, $profesorGrupoPeriodos)) {
                return $this->redirect(['view', 'id' => $model->idProfesor]);
            }
        }

        /*
         * Si llega aquí significa que solo esta desplegando el formulario
         * o que ocurrio un error
         */

        // Renderizado de la vista
        return $this->render('create', [
                    'model' => $model,
                    'persona' => $persona,
                    'usuario' => $usuario,
                    'profesorGrupoPeriodos' => $profesorGrupoPeriodos
        ]);
    }

    /**
     * 
     * @param Profesor $model
     * @param Persona $persona
     * @param Usuario $usuario
     * @param ProfesorGrupoPeriodos $profesorGrupoPeriodosOriginal
     * @return bool
     */
    private function registrar($model, $persona, $usuario, $profesorGrupoPeriodosOriginal) {

        // Creación de un arreglo de ProfesorGrupoPeriodos segun el formulario
        $profesorGrupoPeriodos = Model::createMultiple(ProfesorGrupoPeriodo::className());

        if (count($profesorGrupoPeriodos) != 0) {
            // Carga multiple de los datos para los objetos de la variable anterior
            Model::loadMultiple($profesorGrupoPeriodos, \Yii::$app->request->post());
        }


        // Inicio de una transacción
        $transaccion = Yii::$app->db->beginTransaction();

        // Se indica que el profesor es de integradora
        $model->enIntegradora = 1;

        // Se asigna el rol "Profesor" al usuario que se creará
        $usuario->rol = "Profesor";

        if (!$model->isNewRecord) {
            // Esta editando
            // Colocando el id del profesor a los objetos ProfesorGrupoProfesor
            foreach ($profesorGrupoPeriodos as $pgp) {
                $pgp->idProfesor = $model->idProfesor;
            }

            // Obtención de los registros que estan en la base de datos pero no en el formulario.
            $profesorGrupoPeriodosOld = array_udiff($profesorGrupoPeriodosOriginal, $profesorGrupoPeriodos, ['app\models\ProfesorGrupoPeriodo', 'compare']);

            // Obtención de los nuevos registros a añadir a la base de datos.
            $profesorGrupoPeriodos = array_udiff($profesorGrupoPeriodos, $profesorGrupoPeriodosOriginal, ['app\models\ProfesorGrupoPeriodo', 'compare']);

            // Eliminación de registros duplicados en el array
            $profesorGrupoPeriodos = \app\models\Utilerias::my_array_unique($profesorGrupoPeriodos);

            // Eliminación de la base de datos de registros viejos
            ProfesorGrupoPeriodo::eliminarMultiple($profesorGrupoPeriodosOld);
        } else {
            // Eliminación de registros duplicados en el array
            $profesorGrupoPeriodos = \app\models\Utilerias::my_array_unique($profesorGrupoPeriodos);
        }

        //validacion ajax
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return \yii\helpers\ArrayHelper::merge(
                            ActiveForm::validateMultiple($profesorGrupoPeriodos), ActiveForm::validate($model), ActiveForm::validate($persona), ActiveForm::validate($usuario)
            );
        }

        // validacion php
        $valid = $model->validate() && $persona->validate() && $usuario->validate();
        $valid = Model::validateMultiple($profesorGrupoPeriodos) && $valid;


        // Definir si los datos son validos
        if ($valid) {
            // Registrar objetos en la base de datos
            if ($model->registrar($persona, $usuario, $profesorGrupoPeriodos, false)) {
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
        } else {
            Utilerias::setFlash('pro-reg-0', Model::MSG_TITLE_FAIL_REG, Model::MSG_ERR_REG_GEN, 5000);
            return false;
        }
    }

    /**
     * Updates an existing Profesor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        // Creación de variables necesarias para la actualización
        $model = Profesor::findOne($id);
        $usuario = $model->idProfesor0;
        $persona = $usuario->idUsuario0;
        $periodoActual = \app\models\Periodo::getPeriodoActualRegistrado();

        if ($periodoActual == null) {
            $profesorGrupoPeriodos = [new ProfesorGrupoPeriodo()];
        } else {
            $profesorGrupoPeriodos = $model->getProfesorGrupoPeriodos()->where(['idPeriodo' => $periodoActual->idPeriodo])->all();
            if (count($profesorGrupoPeriodos) == 0) {
                $profesorGrupoPeriodos = [new ProfesorGrupoPeriodo()];
            }
        }
        
        $profesorGrupoPeriodosAnteriores = $model->getProfesorGrupoPeriodos()->where(['!=', 'idPeriodo', $periodoActual->idPeriodo])->all();

        // Detectar si se esta guardando el registro
        if ($model->load(Yii::$app->request->post()) &&
                $persona->load(Yii::$app->request->post()) &&
                $usuario->load(Yii::$app->request->post())) {

            // Intentar actualizar el profesor
            if ($this->registrar($model, $persona, $usuario, $profesorGrupoPeriodos)) {
                return $this->redirect(['view', 'id' => $model->idProfesor]);
            }
        }

        /*
         * Si llega aquí significa que solo esta desplegando el formulario
         * o que ocurrio un error
         */

        // Renderizado de la vista
        return $this->render('update', [
                    'model' => $model,
                    'persona' => $persona,
                    'usuario' => $usuario,
                    'profesorGrupoPeriodos' => $profesorGrupoPeriodos,
                    'profesorGrupoPeriodosAnteriores' => $profesorGrupoPeriodosAnteriores
        ]);
    }

    /**
     * Deletes an existing Profesor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {

        // Encontrar el profesor con el id provisto
        $profesor = $this->findModel($id);

        // Verificar si el profesor aparece registro en algún comité
        if (count($profesor->idComites) > 0) {

            // Este profesor tiene comites relacionados. No se puede eliminar
            Utilerias::setFlash('pro-del-1', 'El profesor no se pudo eliminar'
                    . ' debido a que hay <b>COMITES</b> relacionados', Model::MSG_TITLE_FAIL_DEL, 5000);

            // Permanecer en la pagina en donde se intento realizar la acción
            return $this->redirect(Yii::$app->request->referrer);
        }

        // Verificar si el profesor tiene grupos asignados
        elseif (count($profesor->profesorGrupoPeriodos)) {

            // Este profesor tiene grupos relacionados. No se puede eliminar
            Utilerias::setFlash('pro-del-2', 'El profesor no se pudo eliminar'
                    . ' debido a que hay <b>GRUPOS</b> relacionados', Model::MSG_TITLE_FAIL_DEL, 5000);

            // Permanecer en la pagina en donde se intento realizar la acción
            return $this->redirect(Yii::$app->request->referrer);
        }

        // Esta libre el tipo
        else {

            try {

                // Inicio de transacción
                $transaccion = Yii::$app->db->beginTransaction();

                // Obtención de registros a eliminar de forma implícita
                $usuario = $profesor->idProfesor0;
                $persona = $usuario->idUsuario0;

                // Proceso de eliminación
                $profesor->delete();
                $usuario->delete();
                $persona->delete();

                /*
                 *  Si llegamos aqui quiere decir que todo salió bien.
                 *  Hacer commit y redireccionar al index
                 */
                $transaccion->commit();
                return $this->redirect(['index']);
            } catch (Exception $ex) {

                /*
                 *  Ocurrió un error al eliminar el registro. Hacer rollback y
                 * lanzar un mensaje de error.
                 */
                $transaccion->rollBack();
                Utilerias::setFlash('pro-del-3', Model::MSG_ERR_DEL_GEN, Model::MSG_TITLE_FAIL_DEL, 5000);
            }
        }
    }

    /**
     * Finds the Profesor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Profesor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
