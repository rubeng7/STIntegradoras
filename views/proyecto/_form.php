<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Proyecto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proyecto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del proyecto</h4></div>
        <div class="panel panel-body">

            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcion')->textarea(['maxlength' => true]) ?>

            <?=
            $form->field($model, 'fechaInicio')->widget(DatePicker::className(), [
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'yearRange' => '-115:+0',
                    'changeYear' => true],
                'options' => [
                    'class' => 'form-control',
                    'readonly' => true,
                    'style' => 'background-color:#fff; cursor:text'
                ]
            ])
            ?>

            <?=
            $form->field($model, 'limite')->widget(DatePicker::className(), [
                'dateFormat' => 'dd/MM/yyyy',
                'clientOptions' => [
                    'yearRange' => '-115:+0',
                    'changeYear' => true],
                'options' => [
                    'class' => 'form-control',
                    'readonly' => true,
                    'style' => 'background-color:#fff; cursor:text'
                ]
            ])
            ?>
            
            <div class="panel panel-default" style="padding: 1%">
                <?= $form->field($model, 'idEmpresa', ['options' => ['style' => 'display:none']])->textInput() ?>
                <label>Empresa</label>
                <div class="alert alert-danger" id="campoEmpresa">
                    No se ha seleccionado ninguna empresa
                </div>
                <div align="right">
                    <?= Html::button('Buscar', ['class' => 'btn btn-primary', 'id' => 'botonBuscarEmpresa']) ?>
                </div>
            </div>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
