<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Utilerias;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Comite */
/* @var $periodo app\models\Periodo */
/* @var $form yii\widgets\ActiveForm */
Utilerias::lanzarFlashes();
?>

<div class="comite-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form', 'enableAjaxValidation' => false]); ?>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del comité</h4></div>
        <div class="panel panel-body">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>

            <div class="panel panel-default" id="divComboPeriodo" style="padding: 1%">
                <?= $form->field($model, 'idPeriodo')->dropDownList(app\models\Periodo::mapeaPeriodos()) ?>
                <div align="right"><?= Html::button('Nuevo periodo', ['onclick' => 'nuevoPeriodo();$("#modalPeriodo").modal("show");', 'class' => 'btn btn-primary', 'style' => 'margin: 10px 10px;']) ?></div>
            </div>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Profesores integrantes</h4></div>
        <div class="panel panel-body">

        </div>
    </div>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php
    ActiveForm::end();

    Modal::begin([
        'header' => '<h3 align=center>Nuevo periodo</h3>',
        'id' => 'modalPeriodo',
    ]);
    echo '<div id="divNewPeriodo"></div>';
    Modal::end();

    $js = '
        // FUNCION PARA REGISTRAR UN NUEVO PERIODO

        function nuevoPeriodo() {
            
            $.ajax({
                url: "' . \yii\helpers\Url::toRoute(['periodo/create']) . '",
                data: $("#formPeriodo").serialize(),
                type: "post",
                dataType: "json",
                success: function (data) {
                    if(data.status == "failure") {
                        $("#divNewPeriodo").html(data.div);
                        $(document).on("beforeSubmit", "#formPeriodo", function (e) {
                                return nuevoPeriodo();
                                //e.preventDefault();
                        });
                    } else {
                        $(this).find("#divComboPeriodo").find("select").load("' . \yii\helpers\Url::toRoute(['periodo/carga-combo-dependiente']) . '?"+"id="+"todos");
                        $("#modalPeriodo").modal("hide");
                    }
                }
            });
            return false;
        }
        ';
    $this->registerJs($js, \yii\web\View::POS_END);
    ?>

</div>
