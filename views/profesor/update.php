<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$nombre = $model->idProfesor0->idUsuario0->toString();

$this->title = 'Actualizar Profesor: ' . $nombre;
$this->params['breadcrumbs'][] = ['label' => 'Profesores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $nombre, 'url' => ['view', 'id' => $model->idProfesor]];
$this->params['breadcrumbs'][] = 'Actualizar';

//echo ($valid == true) ? 'si es valido' : 'no es valido';
?>
<div class="profesor-update">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
        'persona' => $persona,
        'usuario' => $usuario,
        'profesorGrupoPeriodos' => $profesorGrupoPeriodos,
    ]) ?>

</div>
