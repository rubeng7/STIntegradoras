<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\bootstrap\Modal;

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
        <div class="panel panel-heading"><h4>Referente a los grupos</h4></div>
        <div class="panel panel-body" style="padding: 1%">
            <div style="display: none"><?= $form->field($model, 'enIntegradora')->checkbox()->label('') ?></div>
            <p>Registros duplicados serán ignorados</p>
            <div id="divGrupos">
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
                                <th class="text-center col-xs-2">Detalles</th>
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
                                        <div class="detalles"></div>
                                    </td>
                                    <td align="center" class="vcenter">
                                        <div class="divComboPeriodo"><?= $form->field($profesorGrup, "[$i]idPeriodo", [])->dropDownList(app\models\Periodo::mapeaPeriodos())->label('') ?></div>
                                    </td>
                                    <td class="text-center vcenter">
                                        <div onclick="eliminarUnicoRegistro()" style="display:inline-block"><button type="button" class="delete-item btn btn-danger btn-xs"><span class="fa fa-minus"></span></button></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" align="right">
                                    <?= Html::button('Nuevo periodo', ['onclick' => 'nuevoPeriodo();$("#modalPeriodo").modal("show");', 'class' => 'btn btn-primary', 'style' => 'margin: 10px 10px;']) ?>
                                </td>
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

    Modal::begin([
        'header' => '<h3>Buscar grupos</h3>',
        'id' => 'modalGrupos',
        'options' => [],
        'size' => 'modal-lg',
        'clientEvents' => ['hidden.bs.modal' => "function(){verificarEleccion()}"]
    ]);
    echo '<div id="divModalGrupos"></div>';
    Modal::end();
    
    Modal::begin([
        'header' => '<h3 align=center>Nuevo periodo</h3>',
        'id' => 'modalPeriodo',
        'clientEvents' => ['hidden.bs.modal' => "function(){verificarEleccion()}"]
    ]);
    echo '<div id="divNewPeriodo"></div>';
    Modal::end();

    $js = '
        
        // CORRECCIONES DE ESTILO
        
        $("#modalGrupos .modal-dialog").css("width", "90%");
        
        // FUNCION PARA BUSCAR UN GRUPO

        function addGrupo(id) {
            if (id == null) {
                $("#divModalGrupos").load("' . \yii\helpers\Url::toRoute(['grupo/select']) . '");
                $("#modalGrupos").modal("show");
            } else {
                var $filas = $("#divGrupos .filas");
                var tam = $filas.size();
                $filas[tam -1].value = id;
                //$("#divGrupos #add-item-2").attr("style", "display:none");
                //$("#divGrupos .add-item").attr("style", "display:auto");
                detallesGrupos();
                $("#modalGrupos").modal("hide");
            }
            return false;
        }
        

        // EVENTO PARA EL BOTON DE BUSQUEDA DE GRUPOS
        
        $("#divGrupos #add-item-2").click(function() {
            addGrupo();
        });
        
        
        // FUNCIONES PARA LA CARGA DE LOS DETALLES DE GRUPOS

        detallesGrupos();
        
        function detallesGrupos() {
            
            // Guardar las filas de los grupos en un objeto jQuery
            var $filas = $("#divGrupos .form-options-item");
            
            // Recorrer las filas
            $filas.each(function(index) {
                // Obtener el id del input idGrupo en la fila actual
                var id = $(this).find("input").val();
                
                // Obtener el numero de filas
                var tam = $filas.size();
                
                if(tam == 1) {
                    // Si solo hay una fila...
                    if(id == null || id == "") {   
                        // Y si esa fila esta vacia
                        $("#divGrupos #add-item-2").attr("style", "display:auto");
                        $("#divGrupos .add-item").attr("style", "display:none");
                        $("#profesor-enintegradora").prop("checked", "");
                    } else {
                        // Si no esta vacia
                        $("#divGrupos #add-item-2").attr("style", "display:none");
                        $("#divGrupos .add-item").attr("style", "display:auto");
                        $("#profesor-enintegradora").prop("checked", "checked");
                    }
                } else {
                    // Si hay mas de una fila
                    $("#divGrupos #add-item-2").attr("style", "display:none");
                    $("#divGrupos .add-item").attr("style", "display:auto");
                    $("#profesor-enintegradora").prop("checked", "checked");
                }
                
                if(id == null || id == "") {
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['grupo/view-modal']) . '?"+"id=0");
                    $(this).find(".celdaNombre").html("No se ha seleccionado un grupo");                    
                    //$("#divGrupos #add-item-2").attr("style", "display:auto");
                    //$("#divGrupos .add-item").attr("style", "display:none");
                } else {
                    $(this).find(".celdaNombre").load("' . \yii\helpers\Url::toRoute(['grupo/get-datos']) . '?"+"id="+id);
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['grupo/view-modal']) . '?"+"id="+id);
                    //$(this).find(".divComboPeriodo").find("select").load("' . \yii\helpers\Url::toRoute(['periodo/carga-combo-dependiente']) . '?"+"id="+id);
                }
                $(this).find(".divComboPeriodo").find("select").load("' . \yii\helpers\Url::toRoute(['periodo/carga-combo-dependiente']) . '?"+"id="+"todos");
            });
        }
        
        // EVENTOS DE CONTROL PARA LA CARGA DE GRUPOS

        var controlGrupo = false;
        
        $("#divGrupos .dynamicform_wrapper").on("afterInsert", function(e, item) {    
            
            if(controlGrupo == false){
                addGrupo();
            }
        });
        
        $("#divGrupos .dynamicform_wrapper").on("afterDelete", function(e, item) {
            detallesGrupos();
        });
        
        function eliminarUnicoRegistro(){
            var $filas = $("#divGrupos .form-options-item");
            var noFilas = $filas.size();
            $filas.each(function(index) {
                if(noFilas == 1){
                    $(this).find("input").val("");
                }
            });
            detallesGrupos();
        }
        
        function verificarEleccion(){
            var $filas = $("#divGrupos .filas");
            var $bot = $("#divGrupos .delete-item");
            var tam = $filas.size();
            
            
            if($filas[tam -1].value == "") {
                $bot[tam - 1].click();
            }
        }
        

        // FUNCION PARA REGISTRAR UN NUEVO PERIODO
        
        function nuevoPeriodo() {
            var $filas = $("#divGrupos .filas");
            var tam = $filas.size();
            if($filas[tam -1].value != "") {
                //Crear nueva fila
                controlGrupo = true;
                $(".add-item").click();
                controlGrupo = false;
            }
            
            $.ajax({
                url: "' . \yii\helpers\Url::toRoute(['periodo/create']) . '",
                data: $(this).serialize(),
                type: "post",
                dataType: "json",
                success: function (data) {
                    if(data.status == "failure") {
                        $("#divNewPeriodo").html(data.div);
                        $("#divNewPeriodo form").submit(nuevoPeriodo);
                    } else {
                        detallesGrupos();
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
