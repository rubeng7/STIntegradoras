<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Utilerias;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\models\Comite */

rmrevin\yii\fontawesome\AssetBundle::register($this);
?>
<div class="comite-view">

    <?php
    if ($tipo == 2) {
        //$this->title = $model->persona->nombre . ' ' . $model->persona->apellidoPat . ' ' . $model->persona->apellidoMat;
        Modal::begin([
            'header' => '<h3 align=center>Detalle comité</h3>',
            'id' => '123' . "$model->idComite",
            'toggleButton' => [
                'label' => '<i class="fa fa-ellipsis-v"></i>',
                'class' => 'btn btn-link',
            ]
        ]);
        echo '<h4 align="left">' . Html::encode($this->title) . '</h4>';
        echo DetailView::widget([
            'model' => $model,
            'attributes' => [
                'idComite',
                'nombre',
                'descripcion',
                [
                    'attribute' => 'idPeriodo',
                    'value' => Utilerias::getNombreMes($model->idPeriodo0->mesInicio) . ' - ' . Utilerias::getNombreMes($model->idPeriodo0->mesFin) . ' ' . $model->idPeriodo0->anio
                ]
            ],
        ]);
        Modal::end();
    } else {
        Modal::begin([
            'header' => '<h3 align=center>Detalle comité</h3>',
            'id' => '123' . "$model",
            'toggleButton' => [
                'label' => '<i class="fa fa-ellipsis-v" aria-hidden="true"></i>',
                'class' => 'btn btn-link',
            ]
        ]);
        echo "No ha seleccionado un comité";
        Modal::end();
    }
    ?>

</div>
