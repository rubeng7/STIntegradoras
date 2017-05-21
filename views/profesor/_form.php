<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */
/* @var $persona app\models\Persona */
/* @var $usuario app\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="profesor-form">

    <?php
    $form = ActiveForm::begin(['enableAjaxValidation' => false,
                'id' => 'dynamic-form']);
    ?>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos personales y escolares</h4></div>
        <div class="panel panel-body" style="padding: 1%">
            <?= $form->field($persona, 'nombre')->textInput(['maxlength' => true]) ?>

            <?= $form->field($persona, 'paterno')->textInput(['maxlength' => true]) ?>

            <?= $form->field($persona, 'materno')->textInput(['maxlength' => true]) ?>

            <?= $form->field($persona, 'idDivision')->dropDownList(\app\models\Division::listaDivisionesCombo(), ['prompt' => 'Seleccione'])->label('División') ?>

            <?= $form->field($model, 'nivelEstudios')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'especialidad')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Referente a función</h4></div>
        <div class="panel panel-body" style="padding: 1%">

            <?= Html::label('Asignación', 'asignacion', ['class' => 'control-label']) ?>
            <br/><br/>

            <?= $form->field($model, 'enComite')->checkbox(['label' => 'Miembro de comité']) ?>
            <?= $form->field($model, 'enIntegradora')->checkbox(['label' => 'Profesor de Integradora']) ?>

            <div id="divGrupos" style="display: none">
                <?php
                rmrevin\yii\fontawesome\AssetBundle::register($this);
                DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.form-options-body', // required: css class selector
                    'widgetItem' => '.form-options-item', // required: css class
                    //'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.delete-item', // css class
                    'model' => $profesorGrupoPeriodos[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'idGrupo',
                        'idPeriodo'
                    ],
                ]);
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-clone"></i> Grupos</h4></div>
                    <table class="table table-bordered table-responsive table-striped margin-b-none">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Grupo</th>
                                <th class="text-center col-xs-2">Periodo</th>
                                <th class="text-center vcenter col-xs-2">
                                    <button type="button" class="add-item btn btn-success btn-xs" style="display: none">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" id="add-item-2">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="form-options-body">
                            <?php foreach ($profesorGrupoPeriodos as $i => $profesorGrup) : ?>
                                <tr class="form-options-item">
                                    <td class="col-xs-1">
                                        <?php
                                        echo $form->field($profesorGrup, "[$i]idGrupo")->textInput(['readonly' => true, 'class' => 'form-control filas'])->label('');
                                        ?>
                                    </td>
                                    <td class="vcenter celdaNombre" align="center">
                                        No ha seleccionado un grupo
                                    </td>
                                    <td align="center" class="vcenter">
                                        No hay información que mostrar
                                    </td>
                                    <td class="text-center vcenter">
                                        <button type="button" class="delete-item btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>

                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    DynamicFormWidget::end();
                    ?>
                </div>
            </div>

            <div id="divComites" style="display: none">
                <?php
                rmrevin\yii\fontawesome\AssetBundle::register($this);
                DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.form-options-body', // required: css class selector
                    'widgetItem' => '.form-options-item', // required: css class
                    //'limit' => 4, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.delete-item', // css class
                    'model' => $comitesProfesores[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'idComite',
                    ],
                ]);
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-clone"></i> Comites</h4></div>
                    <table class="table table-bordered table-responsive table-striped margin-b-none">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center col-xs-2">Detalles</th>
                                <th class="text-center vcenter col-xs-2">
                                    <button type="button" class="add-item btn btn-success btn-xs" style="display: none">
                                        <i class="fa fa-search"></i>
                                    </button>
                                    <button type="button" class="btn btn-success btn-xs" id="add-item-2">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="form-options-body">
                            <?php foreach ($comitesProfesores as $i => $comiteP) : ?>
                                <tr class="form-options-item">
                                    <td class="col-xs-1">
                                        <?php
                                        echo $form->field($comiteP, "[$i]idComite")->textInput(['readonly' => true, 'class' => 'form-control filas'])->label('');
                                        ?>
                                    </td>
                                    <td class="vcenter celdaNombre" align="center">
                                        No ha seleccionado un comite
                                    </td>
                                    <td align="center" class="vcenter">
                                        <div class="detalleRepresentante12"></div>
                                    </td>
                                    <td class="text-center vcenter">
                                        <button type="button" class="delete-item btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>

                            </tr>
                        </tfoot>
                    </table>
                    <?php
                    DynamicFormWidget::end();
                    ?>
                </div>
            </div>
        </div>
    </div>


    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Datos del usuario</h4></div>
        <div class="panel panel-body" style="padding: 1%">
            <?= $form->field($usuario, 'username')->textInput(['maxlength' => true]) ?>

            <?= $form->field($usuario, 'password')->passwordInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php
    ActiveForm::end();

    $js = '
        
        $("#profesor-encomite").change(function() {
            if($(this).is(":checked")){
                $("#divComites").show();
            } else {
                $("#divComites").hide();
            }
        });
        
        $("#profesor-enintegradora").change(function() {
            if($(this).is(":checked")){
                $("#divGrupos").show();
            } else {
                $("#divGrupos").hide();
            }
        });
        
        ';

    $this->registerJs($js, \yii\web\View::POS_END);
    ?>

</div>
