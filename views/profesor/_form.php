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
        <div class="panel panel-heading"><h4>Referente a función</h4></div>
        <div class="panel panel-body" style="padding: 1%">

            <?= $form->field($model, 'enComite')->checkbox(['label' => 'Es miembro de algún comité']) ?>
            <?= $form->field($model, 'enIntegradora')->checkbox(['label' => 'Es profesor de integradora']) ?>

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
                    'widgetContainer' => 'dynamicform_wrapper2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
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
                                        <div class="detalles"></div>
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
        'header' => '<h3>Buscar comites</h3>',
        'id' => 'modalComites',
        'options' => [],
        'size' => 'modal-lg',
        'clientEvents' => ['hidden.bs.modal' => "function(){verificarEleccionComite();}"]
    ]);
    echo '<div id="divModalComites"></div>';
    Modal::end();

    $js = '
        
        // CORRECCIONES DE ESTILO
        
        $("#modalComites .modal-dialog").css("width", "90%");
        $("#modalGrupos .modal-dialog").css("width", "90%");
        
        
        // FUNCIONES PARA EVENTO DE CAMBIO DE SELECCIÓN CHECKBOX

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
        

        // FUNCION PARA BUSCAR UN COMITE

        function addComite(id) {
            if (id == null) {
                $("#divModalComites").load("' . \yii\helpers\Url::toRoute(['comite/select']) . '");
                $("#modalComites").modal("show");
            } else {
                var $filas = $("#divComites .filas");
                var tam = $filas.size();
                $filas[tam -1].value = id;
                $("#divComites #add-item-2").attr("style", "display:none");
                $("#divComites .add-item").attr("style", "display:auto");
                detallesComites();
                $("#modalComites").modal("hide");
            }
            return false;
        }
        

        // EVENTO PARA EL BOTON DE BUSQUEDA DE COMITES
        
        $("#divComites #add-item-2").click(function() {
            addComite();
        });
        
        
        // FUNCIONES PARA LA CARGA DE LOS DETALLES DE COMITES

        detallesComites();
        
        function detallesComites() {
            
            var $filas = $("#divComites .form-options-item");
            $filas.each(function(index) {
                var id = $(this).find("input").val();
                
                if(id == null || id == "") {
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['comite/view-modal']) . '?"+"id=0");
                } else {
                    $(this).find(".celdaNombre").load("' . \yii\helpers\Url::toRoute(['comite/get-datos']) . '?"+"id="+id);
                    $(this).find(".detalles").load("' . \yii\helpers\Url::toRoute(['comite/view-modal']) . '?"+"id="+id);
                }
            });
        }
        
        // EVENTOS DE CONTROL PARA LA CARGA DE COMITES

        var controlComite = false;
        
        $("#divComites .dynamicform_wrapper2").on("afterInsert", function(e, item) {    
            
            if(controlComite == false){
                addComite();
            }
        });
        
        $("#divComites .dynamicform_wrapper2").on("afterDelete", function(e, item) {
            detallesComite();    
        });
        
        
        function verificarEleccionComite(){
            var $filas = $("#divComites .filas");
            var $bot = $("#divComites .delete-item");
            var tam = $filas.size();
            
            
            if($filas[tam -1].value == "") {
                $bot[tam - 1].click();
            }
        }
        
        
        
        ';

    $this->registerJs($js, \yii\web\View::POS_END);
    ?>

</div>
