<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Esquema */

$this->title = 'Actualizar Esquema: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Esquemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->nombre]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="esquema-update">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
