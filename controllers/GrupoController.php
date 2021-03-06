<?php

namespace app\controllers;

use Yii;
use app\models\Grupo;
use app\models\SearchGrupo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Utilerias;

/**
 * GrupoController implements the CRUD actions for Grupo model.
 */
class GrupoController extends Controller
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
     * Lists all Grupo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchGrupo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }  
    
    public function actionSelect() {

        $searchModel = new SearchGrupo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('indexModal', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Grupo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
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
        return Grupo::findOne($id)->toString();
        
    }

    /**
     * Creates a new Grupo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grupo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idGrupo]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Grupo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idGrupo]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Grupo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $grupo = $this->findModel($id);
        if(count($grupo->alumnoGrupoPeriodos) > 0) {
            // Hay alumnos en este grupo!!
            Utilerias::setFlash('gru-del-1', 'No se puede eliminar este grupo '
                    . 'porque hay <b>ALUMNOS</b> relacionados', 'Problemas al eliminar', 5000);
        } elseif(count($grupo->profesorGrupoPeriodos) > 0) {
            // Hay profesores relacionados a este grupo!!
            Utilerias::setFlash('gru-del-1', 'No se puede eliminar este grupo '
                    . 'porque hay <b>PROFESORES</b> relacionados', 'Problemas al eliminar', 5000);
        } elseif(count($grupo->equipos) > 0) {
            // Hay equipos en este grupo!!
            Utilerias::setFlash('gru-del-1', 'No se puede eliminar este grupo '
                    . 'porque hay <b>EQUIPOS</b> relacionados', 'Problemas al eliminar', 5000);
        } else {
            $grupo->delete();
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the Grupo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grupo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grupo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
