<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $model app\models\Comite */
/* @var $periodo app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="comite-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>

    <?= $form->field($periodo, 'mesInicio')->dropDownList(Utilerias::mapeaMeses()) ?>
            
    <?= $form->field($periodo, 'mesFin')->dropDownList(Utilerias::mapeaMeses()) ?>
    
    <?= $form->field($periodo, 'anio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
