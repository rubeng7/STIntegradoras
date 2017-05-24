<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchPeriodo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="periodo-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'idPeriodo') ?>

    <?= $form->field($model, 'mesInicio') ?>

    <?= $form->field($model, 'mesFin') ?>

    <?= $form->field($model, 'anio') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
