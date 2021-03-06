<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Grupo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchGrupo */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = $this->title;
\app\models\Utilerias::lanzarFlashes();
?>
<div class="grupo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Grupo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idGrupo',
            [
                'attribute' => 'cuatrimestre',
                'filter' => Html::activeDropDownList($searchModel, 'cuatrimestre', Grupo::ARRAY_CUATRIMESTRES, ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'attribute' => 'letra',
                'filter' => Html::activeDropDownList($searchModel, 'letra', Grupo::ARRAY_GRUPOS, ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'attribute' => 'turno',
                'filter' => Html::activeDropDownList($searchModel, 'turno', Grupo::ARRAY_TURNOS, ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'attribute' =>'idCarrera0.idDivision0.nombre',
                'label'=>'Division',
                'filter' => Html::activeDropDownList($searchModel, 'idCarrera0.idDivision0.idDivision', app\models\Division::listaDivisionesCombo(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'attribute' =>'idCarrera0.nombre',
                'label'=>'Carrera',
                'filter' => Html::activeDropDownList($searchModel, 'idCarrera', app\models\Carrera::listaCarrerasCombo(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
