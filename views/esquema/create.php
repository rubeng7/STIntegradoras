<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Esquema */

$this->title = 'Crear Esquema';
$this->params['breadcrumbs'][] = ['label' => 'Esquemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esquema-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
