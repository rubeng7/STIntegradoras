<?php

namespace app\controllers;

class PeriodoController extends \yii\web\Controller {

    /**
     * 
     * @param \app\models\Grupo $id
     */
    public function actionCargaComboDependiente($id) {
        $stringOptions = "";

        if ($id == "todos") {
            $periodos = \app\models\Periodo::find()->all();
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

}
