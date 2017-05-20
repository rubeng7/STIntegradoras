<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Esquema */

$this->title = 'Update Esquema: ' . $model->idEsquema;
$this->params['breadcrumbs'][] = ['label' => 'Esquemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idEsquema, 'url' => ['view', 'id' => $model->idEsquema]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="esquema-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
