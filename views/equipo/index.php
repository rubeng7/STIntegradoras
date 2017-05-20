<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEquipo */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Equipos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="equipo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Equipo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idEquipo',
            'nombre',
            'idPeriodo',
            'idGrupo',
            'idProyecto',
            // 'idEsquema',
            // 'idComite',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
