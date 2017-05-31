<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Grupo */
/* @var $form yii\widgets\ActiveForm */
\app\models\Utilerias::lanzarFlashes();
?>

<div class="grupo-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del Grupo</h4></div>
        <div class="panel panel-body">

    <?= $form->field($model, 'cuatrimestre')->dropDownList([ 1 => '1', 2 => '2', 3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7', 8 => '8', 9 => '9', 10 => '10', 11 => '11', 12 => '12', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'letra')->dropDownList([ 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E', 'F' => 'F', 'G' => 'G', 'H' => 'H', 'I' => 'I', 'J' => 'J', 'K' => 'K', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'turno')->dropDownList([ 'Matutino' => 'Matutino', 'Vespertino' => 'Vespertino', 'Nocturno' => 'Nocturno', ], ['prompt' => '']) ?>

    
    
    <?= $form->field($model, 'idCarrera')->dropDownList(\app\models\Carrera::getListaConDivCombo()) ?>

            </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
