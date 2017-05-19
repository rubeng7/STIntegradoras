<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Division */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Divisiones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="division-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idDivision], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $model->idDivision], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estas seguro que quieres eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idDivision',
            'nombre',
            'descripcion',
        ],
    ]) ?>
    
    <br>
    <h4>Carreras</h4>
    <table class="table table-bordered table-responsive table-striped margin-b-none">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->carreras as $i => $carrera) : ?>
                <tr>
                    <td><?=$carrera->nombre?></td>
                    <td><?= $carrera->descripcion?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>
