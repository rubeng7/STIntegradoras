<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Grupo */

$this->title = $model->cuatrimestre . '-'. $model->letra. '    '. $model->turno;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\app\models\Utilerias::lanzarFlashes();
?>
<div class="grupo-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idGrupo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idGrupo], [
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
    ]) ?>
    
    
</div>
