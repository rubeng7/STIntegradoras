<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Utilerias;
use yii\bootstrap\Modal;
use wbraganca\dynamicform\DynamicFormWidget;

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
            <?= $form->field($model, 'idDivision')->dropDownList(app\models\Division::listaDivisionesCombo(), ['prompt' => '']) ?>
            
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcion')->textArea(['maxlength' => true]) ?>

            <div class="panel panel-default" id="divComboPeriodo" style="padding: 1%">
                <?= $form->field($model, 'idPeriodo')->dropDownList(app\models\Periodo::mapeaPeriodos(), ['prompt' => '']) ?>
                <div align="right"><?= Html::button('Nuevo periodo', ['onclick' => 'nuevoPeriodo();$("#modalPeriodo").modal("show");', 'class' => 'btn btn-primary', 'style' => 'margin: 10px 10px;']) ?></div>
            </div>

        </div>
    </div>

    <div class="panel panel-primary">
        <div class="panel panel-heading"><h4>Profesores integrantes</h4></div>
        <div class="panel panel-body">
            <div id="divProfesores">
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
                    'model' => $comiteProfesores[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'idComite',
                    ],
                ]);
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading"><h4><i class="fa fa-clone"></i> Profesores</h4></div>
                    <table class="table table-bordered table-responsive table-striped margin-b-none">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Profesor</th>
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
                            <?php foreach ($comiteProfesores as $i => $cp) : ?>
                                <tr class="form-options-item">
                                    <td class="col-xs-1">
                                        <?php
                                        echo $form->field($cp, "[$i]idProfesor")->textInput(['readonly' => true, 'class' => 'form-control filas'])->label('');
                                        ?>
                                    </td>
                                    <td class="vcenter celdaNombre" align="center">
                                        No se ha seleccionado ningún profesor
                                    </td>
                                    <td align="center" class="vcenter">
                                        <div class="detalles"></div>
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
                                    <?= Html::button('Nuevo profesor', ['onclick' => 'nuevoProfesor();$("#modalPeriodo").modal("show");', 'class' => 'btn btn-primary', 'style' => 'margin: 10px 10px;']) ?>
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
    
    Modal::begin([
        'header' => '<h3>Buscar profesor</h3>',
        'id' => 'modalProfesores',
        'options' => [],
        'size' => 'modal-lg',
        'clientEvents' => ['hidden.bs.modal' => "function(){verificarEleccion()}"]
    ]);
    echo '<div id="divModalProfesores"></div>';
    Modal::end();
    
    Modal::begin([
        'header' => '<h3 align=center>Nuevo profesor</h3>',
        'id' => 'modalProfesor',
        'clientEvents' => ['hidden.bs.modal' => "function(){verificarEleccion()}"]
    ]);
    echo '<div id="divNewProfesor"></div>';
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
                        $("body").on("beforeSubmit", "#formPeriodo", function () {
                            return nuevoPeriodo();
                        });
                    } else {
                        $("body").off("beforeSubmit");
                        $(document).find("#divComboPeriodo").find("select").load("' . \yii\helpers\Url::toRoute(['periodo/carga-combo-dependiente']) . '?"+"id="+"todos");
                        $("#modalPeriodo").modal("hide");
                    }
                }
            });
            return false;
        }
        
        // CORRECCIÓN DE ESTILO DE VENTANA MODAL
        $("#modalProfesores .modal-dialog").css("width", "90%");
        

        // FUNCIÓN PARA LA CARGA DE PROFESORES
        function addProfesor(id) {
            if (id == null) {
                // Solo se realiza la carga de la tabla de profesores y se muestra el modal
                $("#divModalProfesores").load("' . \yii\helpers\Url::toRoute(['profesor/select']) . '");
                $("#modalProfesores").modal("show");
            } else {
                // Se carga el id seleccionado y se refresca la lista de profesores
                var $filas = $("#divProfesores .filas");
                var tam = $filas.size();
                $filas[tam -1].value = id;
                detallesProfesores();
                $("#modalProfesores").modal("hide");
            }
            return false;
        }
        

        // EVENTO PARA EL BOTÓN DE BUSQUEDA DE GRUPOS
        
        $("#divProfesores #add-item-2").click(function() {
            addProfesor();
        });
        
        
        // FUNCIONES PARA LA CARGA DE LOS DETALLES DE GRUPOS

        detallesProfesores();
        
        function detallesProfesores() {
            
            // Guardar las filas de los profesores en un objeto jQuery
            var $filas = $("#divProfesores .form-options-item");
            
            // Recorrer las filas
            $filas.each(function(index) {
                // Obtener el id del input idProfesor en la fila actual
                var id = $(this).find("input").val();
                
                // Obtener el numero de filas
                var tam = $filas.size();
                
                if(tam == 1) {
                    // Si solo hay una fila...
                    if(id == null || id == "") {   
                        // Y si esa fila esta vacia
                        $("#divProfesores #add-item-2").attr("style", "display:auto");
                        $("#divProfesores .add-item").attr("style", "display:none");
                    } else {
                        // Si no esta vacia
                        $("#divProfesores #add-item-2").attr("style", "display:none");
                        $("#divProfesores .add-item").attr("style", "display:auto");
                    }
                } else {
                    // Si hay mas de una fila
                    $("#divProfesores #add-item-2").attr("style", "display:none");
                    $("#divProfesores .add-item").attr("style", "display:auto");
                }
                
                if(id == null || id == "") {
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['profesor/view-modal']) . '?"+"id=0");
                    $(this).find(".celdaNombre").html("No se ha seleccionado un profesor");                    
                } else {
                    $(this).find(".celdaNombre").load("' . \yii\helpers\Url::toRoute(['profesor/get-datos']) . '?"+"id="+id);
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['profesor/view-modal']) . '?"+"id="+id);
                }
            });
        }
        
        // EVENTOS DE CONTROL PARA LA CARGA DE GRUPOS

        var controlProfesor = false;
        
        $("#divProfesores .dynamicform_wrapper").on("afterInsert", function(e, item) {    
            
            if(controlProfesor == false){
                addProfesor();
            }
        });
        
        $("#divProfesor .dynamicform_wrapper").on("afterDelete", function(e, item) {
            detallesProfesores();
        });
        
        function eliminarUnicoRegistro(){
            var $filas = $("#divProfesores .form-options-item");
            var noFilas = $filas.size();
            $filas.each(function(index) {
                if(noFilas == 1){
                    $(this).find("input").val("");
                }
            });
            detallesProfesores();
        }
        
        function verificarEleccion(){
            var $filas = $("#divProfesores .filas");
            var $bot = $("#divProfesores .delete-item");
            var tam = $filas.size();
            
            
            if($filas[tam -1].value == "") {
                $bot[tam - 1].click();
            }
        }
        
        ';
    $this->registerJs($js, \yii\web\View::POS_END);
    ?>

</div>
