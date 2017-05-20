<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchEquipo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="equipo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idEquipo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'idPeriodo') ?>

    <?= $form->field($model, 'idGrupo') ?>

    <?= $form->field($model, 'idProyecto') ?>

    <?php // echo $form->field($model, 'idEsquema') ?>

    <?php // echo $form->field($model, 'idComite') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
