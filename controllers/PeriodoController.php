<?php

namespace app\controllers;

use Yii;
use app\models\Periodo;
use app\models\SearchPeriodo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PeriodoController implements the CRUD actions for Periodo model.
 */
class PeriodoController extends Controller {

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
     * Lists all Periodo models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new SearchPeriodo();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Periodo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Periodo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Periodo();
        $model->idPeriodo = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (\Yii::$app->request->isAjax) {
                return Json::encode([
                            'status' => 'success',
                            'div' => "$model->idPeriodo",
                ]);
            } else {
                return $this->redirect(['view', 'id' => $model->idPeriodo]);
            }
            
        } else {
            if (\Yii::$app->request->isAjax) {
                return Json::encode([
                            'status' => 'failure',
                            'div' => $this->renderAjax('_form', [
                                'model' => $model
                            ])
                ]);
            } else {
                return $this->render('create', [
                            'model' => $model,
                ]);
            }
        }
    }

    /**
     * Updates an existing Periodo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idPeriodo]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Periodo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * 
     * @param \app\models\Grupo $id
     */
    public function actionCargaComboDependiente($id) {
        $stringOptions = "";

        if ($id == "todos") {
            $periodos = \app\models\Periodo::find()->orderBy('mesInicio DESC, anio DESC')->all();
            foreach ($periodos as $periodo) {
                $stringOptions .= "<option value='$periodo->idPeriodo'>" . $periodo->toString() . "</option>";
            }
        } else {
            $alumnoGrupoPeriodos = \app\models\Grupo::findOne($id)->alumnoGrupoPeriodos;
            foreach ($alumnoGrupoPeriodos as $profGrupPeriodo) {
                $stringOptions .= "<option value='$profGrupPeriodo->idPeriodo'>" . $profGrupPeriodo->idPeriodo0->toString() . "</option>";
            }
        }

        echo $stringOptions;
    }

    /**
     * Finds the Periodo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Periodo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Periodo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
