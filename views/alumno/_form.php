<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Alumno */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumno-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del Alumno</h4></div>
        <div class="panel panel-body">

    <?= $form->field($model, 'idAlumno')->textInput() ?>

    <?= $form->field($model, 'matricula')->textInput(['maxlength' => true]) ?>
            
            </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
