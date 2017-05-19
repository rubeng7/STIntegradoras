<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchCarrera */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carreras';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carrera-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Carrera', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idCarrera',
            [
                'attribute' => 'nivel',
                'filter' => Html::activeDropDownList($searchModel, 'nivel', [ 'TSU' => 'TSU', 'INGENIERIA' => 'INGENIERIA', 'INGENIERIA PROFESIONAL' => 'INGENIERIA PROFESIONAL', 'LICENCIATURA' => 'LICENCIATURA', 'MAESTRIA' => 'MAESTRIA', 'DOCTORADO' => 'DOCTORADO', 'OTRO' => 'OTRO', ], ['class' => 'form-control', 'prompt' => 'Cualquiera']),
            ],
            'nombre',
            'descripcion',
            [
                'attribute' => 'idDivision0.nombre',
                'filter' => Html::activeDropDownList($searchModel, 'idDivision', app\models\Division::listaDivisionesCombo(), ['class' => 'form-control', 'prompt' => 'Cualquiera']),
                'label' => 'División'
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
