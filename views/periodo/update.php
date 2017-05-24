<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Periodo */

$this->title = 'Update Periodo: ' . $model->idPeriodo;
$this->params['breadcrumbs'][] = ['label' => 'Periodos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idPeriodo, 'url' => ['view', 'id' => $model->idPeriodo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="periodo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
