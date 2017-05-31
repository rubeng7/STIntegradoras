<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carrera */
/* @var $form yii\widgets\ActiveForm */
\app\models\Utilerias::lanzarFlashes();
?>

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos de la Carrera</h4></div>
        <div class="panel panel-body">

    <?= $form->field($model, 'nivel')->dropDownList([ 'TSU' => 'TSU', 'INGENIERIA' => 'INGENIERIA', 'INGENIERIA PROFESIONAL' => 'INGENIERIA PROFESIONAL', 'LICENCIATURA' => 'LICENCIATURA', 'MAESTRIA' => 'MAESTRIA', 'DOCTORADO' => 'DOCTORADO', 'OTRO' => 'OTRO', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'idDivision')->dropDownList(\app\models\Division::listaDivisionesCombo()) ?>

            </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
