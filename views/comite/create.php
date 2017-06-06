<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Comite */

$this->title = 'Crear Comite';
$this->params['breadcrumbs'][] = ['label' => 'Comites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comite-create">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?= $this->render('_form', [
        'model' => $model,
        'comiteProfesores' => $comiteProfesores
    ]) ?>

</div>
