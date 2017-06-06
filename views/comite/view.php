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
        <?=
        Html::a('Eliminar', ['delete', 'id' => $model->idComite], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro que desea ELIMINAR este elemento?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
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
    ])
    ?>

    <br>
    <h4>Profesores que lo integran</h4>
    <table class="table table-bordered table-responsive table-striped margin-b-none">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model->idProfesors as $i => $profesor) : ?>
                <tr>
                    <td><?= $profesor->toString() ?></td>
                    <td><?= Yii::$app->runAction('profesor/view-modal', ['id' => $profesor->idProfesor])?></td>
                </tr>
                <?php
            endforeach;
            if (count($model->idProfesors) == 0) {
                ?>
                <tr>
                    <td colspan="2">No se ha encontrado ningún profesor en este comité</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    
    <br>
    <h4>Equipos evaluados o en evaluación</h4>
    <h5>Las filas en negritas y cursivas corresponden al periodo actual</h5>
    <table class="table table-bordered table-responsive table-striped margin-b-none">
        <thead>
            <tr>
                <th>División</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Equipo</th>
                <th>Periodo</th>
                <th>Detalles</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($model->equipos as $i => $equipo) :
                if ($equipo->idPeriodo0->isCurrentlyDateInPeriodo()) {
                    echo '<tr style="font-weight: bold; font-style:italic">';
                } else {
                    ?><tr><?php
                    }
                    ?>
                    <td><?= $equipo->idGrupo0->idCarrera0->idDivision0->nombre ?></td>
                    <td><?= $equipo->idGrupo0->idCarrera0->nombre ?></td>
                    <td><?= $equipo->idGrupo0->toString() ?></td>
                    <td><?= $equipo->nombre ?></td>
                    <td><?= $equipo->idPeriodo0->toString() ?></td>
                    <td></td>
                </tr>

                <?php
            endforeach;
            if (count($model->equipos) == 0) {
                ?>
                <tr>
                    <td colspan="6">No se ha encontrado ningún equipo relacionado a este comité</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

</div>
