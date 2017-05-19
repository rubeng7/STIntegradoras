<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $model app\models\Comite */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Comites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comite-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idComite], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idComite], [
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
            'idComite',
            'nombre',
            'descripcion',
            [
                'attribute' => 'idPeriodo',
                'value' => Utilerias::getNombreMes($model->idPeriodo0->mesInicio) . ' - ' . Utilerias::getNombreMes($model->idPeriodo0->mesFin) . ' ' . $model->idPeriodo0->anio
            ]
        ],
    ]) ?>

</div>
