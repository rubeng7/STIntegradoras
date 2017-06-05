<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Equipo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipo-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del Equipo</h4></div>
        <div class="panel panel-body">

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'idPeriodo')->textInput() ?>

    <?= $form->field($model, 'idGrupo')->textInput() ?>

    <?= $form->field($model, 'idProyecto')->textInput() ?>

    <?= $form->field($model, 'idEsquema')->textInput() ?>

    <?= $form->field($model, 'idComite')->textInput() ?>
            
             </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
