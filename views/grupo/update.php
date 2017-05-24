<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Grupo */

$this->title = 'Actualizar Grupo: ' . $model->cuatrimestre . '-'. $model->letra. '    '. $model->turno;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cuatrimestre . '-'. $model->letra. '    '. $model->turno, 'url' => ['view', 'id' => $model->idGrupo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="grupo-update">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
