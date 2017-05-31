<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mesInicio')->dropDownList(\app\models\Utilerias::mapeaMeses(), ['prompt' => '']) ?>

    <?= $form->field($model, 'mesFin')->dropDownList(\app\models\Utilerias::mapeaMeses(), ['prompt' => '']) ?>

    <?= $form->field($model, 'anio')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
