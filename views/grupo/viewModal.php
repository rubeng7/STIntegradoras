<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Grupo */

rmrevin\yii\fontawesome\AssetBundle::register($this);
//$this->title = $model->cuatrimestre . '-' . $model->letra . '    ' . $model->turno;
?>
<div class="grupo-view">

    <?php
    if ($tipo == 2) {
        //$this->title = $model->persona->nombre . ' ' . $model->persona->apellidoPat . ' ' . $model->persona->apellidoMat;
        Modal::begin([
            'header' => '<h3 align=center>Detalle del grupo</h3>',
            'id' => '123' . "$model->idGrupo",
            'toggleButton' => [
                'label' => '<i class="fa fa-ellipsis-v"></i>',
                'class' => 'btn btn-link',
            ]
        ]);
        echo '<h4 align="left">' . Html::encode($this->title) . '</h4>';
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'idGrupo',
                'cuatrimestre',
                'letra',
                'turno',
                [
                    'attribute' => 'idCarrera0.idDivision0.nombre',
                    'label' => 'Division'
                ],
                [
                    'attribute' => 'idCarrera0.nombre',
                    'label' => 'Carrera'
                ]
            ],
        ]);
        Modal::end();
    } else {
        Modal::begin([
            'header' => '<h3 align=center>Detalle del grupo</h3>',
            'id' => '123' . "$model",
            'toggleButton' => [
                'label' => '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>',
                'class' => 'btn btn-link',
            ]
        ]);
        echo "No ha seleccionado un grupo";
        Modal::end();
    }
    ?>


</div>
