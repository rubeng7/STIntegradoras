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
     * @param \app\models\Periodo $periodo
     * @return mixed
     */
    private function registrar($model, $periodo) {
        
        if($model->isNewRecord){
            $model->idComite = 0;
            $periodo->idPeriodo = 0;
        }
        
        $peridoExist = Periodo::find()->where(['mesInicio' => $periodo->mesInicio, 'mesFin' => $periodo->mesFin, 'anio' => $periodo->anio])->one();
        if($peridoExist != null) {
            $periodo = $peridoExist;
        }
        
        $transaccion = Yii::$app->db->beginTransaction();
        
        if($periodo->save()){
            $model->idPeriodo = $periodo->idPeriodo;
            if($model->save()){
                $transaccion->commit();
                return $this->redirect(['view', 'id' => $model->idComite]);
            } else {
                // Lanzar alertas
                $transaccion->rollBack();
            }
        } else {
            // Lanzar alertas
            $transaccion->rollBack();
        }
        
    }

    /**
     * Creates a new Comite model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Comite();
        $periodo = new Periodo();

        if ($model->load(Yii::$app->request->post()) && $periodo->load(Yii::$app->request->post())) {
            $this->registrar($model, $periodo);
        }
        return $this->render('create', [
                    'model' => $model,
                    'periodo' => $periodo
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
