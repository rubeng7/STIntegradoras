<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Grupo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchGrupo */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="grupo-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => 'true',
        'id' => 'grupo-index-modal',
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false
            ]
        ],
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

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{select}',
                'buttons' => [
                    'select' => function($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-check"></span>', ['class' => 'btn btn-link seleccionador', 'onclick' => 'addGrupo(' . $key . ')']);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
