<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Comite */

$this->title = 'Actualizar Comite: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Comites', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->idComite]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="comite-update">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
        'comiteProfesores' => $comiteProfesores
    ]) ?>

</div>
