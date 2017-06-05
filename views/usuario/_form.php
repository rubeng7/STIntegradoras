<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>
     <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos de la División</h4></div>
        <div class="panel panel-body">


    <?= $form->field($model, 'idUsuario')->textInput() ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rol')->dropDownList([ 'Superusuario' => 'Superusuario', 'Director' => 'Director', 'Profesor' => 'Profesor', 'Alumno' => 'Alumno', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'activo')->textInput() ?>
            
            </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
