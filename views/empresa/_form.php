<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
/* @var $direccion app\models\Direccion */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos de la Empresa</h4></div>
        <div class="panel panel-body">


    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'giro')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'responsable')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($direccion, 'calle')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($direccion, 'numero')->textInput() ?>
    
    <?= $form->field($direccion, 'ciudad')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($direccion, 'municipio')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($direccion, 'estado')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($direccion, 'cp')->textInput() ?>
    
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
