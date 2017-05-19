<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Proyecto */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Proyectos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$direccion = $model->idEmpresa0->idDireccion0;
?>
<div class="proyecto-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idProyecto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idProyecto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea ELIMINAR este elemento?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idProyecto',
            'nombre',
            'descripcion',
            'fechaInicio',
            'limite',
            [
                'attribute' => 'idEmpresa0.nombre',
                'label' => 'Nombre de la empresa'
            ],
            [
                'attribute' => 'idEmpresa0.giro',
                'label' => 'Giro de la empresa'
            ],
            [
                'attribute' => 'idEmpresa0.responsable',
                'label' => 'Responsable de la empresa'
            ],
            [
                'attribute' => 'idEmpresa0.telefono',
                'label' => 'Telefono de la empresa'
            ],
            [
                'attribute' => 'direccionCompleta',
                'label' => 'Dirección de la empresa',
                'value' => $direccion->calle . ' ' . $direccion->numero . ' ' .
                            $direccion->ciudad . ' ' . $direccion->municipio . ' ' .
                            $direccion->estado . ' CP: ' . $direccion->cp,
            ]
        ],
    ]) ?>

</div>
