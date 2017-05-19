<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Carrera */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carrera-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nivel')->dropDownList([ 'TSU' => 'TSU', 'INGENIERIA' => 'INGENIERIA', 'INGENIERIA PROFESIONAL' => 'INGENIERIA PROFESIONAL', 'LICENCIATURA' => 'LICENCIATURA', 'MAESTRIA' => 'MAESTRIA', 'DOCTORADO' => 'DOCTORADO', 'OTRO' => 'OTRO', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'idDivision')->dropDownList(\app\models\Division::listaDivisionesCombo()) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
