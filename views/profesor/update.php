<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = 'Actualizar Profesor: ' . $model->idProfesor;
$this->params['breadcrumbs'][] = ['label' => 'Profesores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idProfesor, 'url' => ['view', 'id' => $model->idProfesor]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="profesor-update">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
