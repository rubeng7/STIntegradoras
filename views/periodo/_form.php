<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mesInicio')->dropDownList([ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'mesFin')->dropDownList([ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'anio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
