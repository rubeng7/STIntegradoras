<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = $model->idProfesor0->idUsuario0->toString();
$this->params['breadcrumbs'][] = ['label' => 'Profesores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\app\models\Utilerias::lanzarFlashes();
?>
<div class="profesor-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Actualizar', ['update', 'id' => $model->idProfesor], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a('Eliminar', ['delete', 'id' => $model->idProfesor], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Esta seguro de elimnar este elemento?',
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idProfesor',
            [
                'attribute' => 'idProfesor0.idUsuario0.nombre',
                'value' => $model->idProfesor0->idUsuario0->toString(),
                'label' => 'Nombre completo',
            ],
            [
                'attribute' => 'idProfesor0.idUsuario0.idDivision0.nombre',
                'label' => 'División'
            ],
            'idProfesor0.username',
            'idProfesor0.rol',
            [
                'attribute' => 'idProfesor0.activo',
                'label' => 'Esta activo',
                'value' => $model->idProfesor0->activo == 1 ?
                        '<span class="glyphicon glyphicon-ok text-success"></span>' :
                        '<span class="glyphicon glyphicon-remove text-danger"></span>',
                'format' => 'html'
            ],
            'nivelEstudios',
            'especialidad',
            [
                'atribute' => 'enComite',
                'label' => 'Pertenece a algún comité',
                'value' => $model->enComite == 1 ?
                        '<span class="glyphicon glyphicon-ok text-success"></span>' :
                        '<span class="glyphicon glyphicon-remove text-danger"></span>',
                'format' => 'html'
            ],
            [
                'atribute' => 'enIntegradora',
                'label' => 'Ha impartido la clase de tarea integradora',
                'value' => $model->enIntegradora == 1 ?
                        '<span class="glyphicon glyphicon-ok text-success"></span>' :
                        '<span class="glyphicon glyphicon-remove text-danger"></span>',
                'format' => 'html'
            ],
        ],
    ])
    ?>

    <br>
    <h4>Comités en los que ha participado</h4>
    <h5>Las filas en negritas y cursivas corresponden al periodo actual</h5>
    <table class="table table-bordered table-responsive table-striped margin-b-none">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Periodo</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($model->idComites as $i => $comite) :
                if ($comite->idPeriodo0->isCurrentlyDateInPeriodo()) {
                    echo '<tr style="font-weight: bold; font-style:italic">';
                } else {
                    ?><tr><?php
                    }
                    ?>
                    <td><?= $comite->nombre ?></td>
                    <td><?= $comite->idPeriodo0->toString() ?></td>
                    <td><?= $comite->descripcion ?></td>
                </tr>
                <?php
            endforeach;
            if (count($model->idComites) == 0) {
                ?>
                <tr>
                    <td colspan="3">No se ha encontrado ningún comité relacionado con este profesor</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <br>
    <h4>Grupos que ha asesorado</h4>
    <h5>Las filas en negritas y cursivas corresponden al periodo actual</h5>
    <table class="table table-bordered table-responsive table-striped margin-b-none">
        <thead>
            <tr>
                <th>División</th>
                <th>Carrera</th>
                <th>Grupo</th>
                <th>Periodo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($model->profesorGrupoPeriodos as $i => $pgp) :
                if ($pgp->idPeriodo0->isCurrentlyDateInPeriodo()) {
                    echo '<tr style="font-weight: bold; font-style:italic">';
                } else {
                    ?><tr><?php
                    }
                    ?>
                    <td><?= $pgp->idGrupo0->idCarrera0->idDivision0->nombre ?></td>
                    <td><?= $pgp->idGrupo0->idCarrera0->nombre ?></td>
                    <td><?= $pgp->idGrupo0->toString() ?></td>
                    <td><?= $pgp->idPeriodo0->toString() ?></td>
                </tr>

                <?php
            endforeach;
            if (count($model->profesorGrupoPeriodos) == 0) {
                ?>
                <tr>
                    <td colspan="3">No se ha encontrado ningún grupo relacionado con este profesor</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>

</div>
