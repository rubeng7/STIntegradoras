<?php

use yii\helpers\Html;
use kartik\grid\GridView;

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
        <?= Html::a('Crear Equipo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'responsive' => true,
        'pjax' => true,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' =>'idGrupo0.idCarrera0.nombre',
                'label'=>'Carrera',
                'filter' => Html::activeDropDownList($searchModel, 'idGrupo0.idCarrera0.idCarrera', app\models\Carrera::getListaConDivCombo(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            'nombre',
            [
                'label'=>'Periodo',
                'attribute' =>'idPeriodo',
                'value' => function($model, $key, $index, $grid){
                    return $model->idPeriodo0->toString();
        
                },
            ],
            [
                'label' => 'Grupo',
                'attribute' => 'idGrupo',
                'value' => function($model, $key, $index, $grid){
                    return $model->idGrupo0->toString();
        
                },
            ],
            [
                'label' => 'Proyecto',
                'attribute' => 'idProyecto',
                'value' => 'idProyecto0.nombre',
            ],
            
            [
                'label' => 'Comite',
                'attribute' => 'idComite',
                'value' => 'idComite0.nombre',
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
