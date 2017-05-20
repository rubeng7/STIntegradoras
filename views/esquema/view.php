<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Esquema */

$this->title = $model->idEsquema;
$this->params['breadcrumbs'][] = ['label' => 'Esquemas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="esquema-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->idEsquema], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->idEsquema], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'idEsquema',
            'nombre',
            'noIntegradora',
            'noFases',
            'fechaCreacion',
            'idCarrera',
        ],
    ]) ?>

</div>
