<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProfesor */
/* @var $dataProvider yii\data\ActiveDataProvider */

\app\models\Utilerias::lanzarFlashes();
?>
<div class="profesor-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'id' => 'profesor-index-modal',
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'idProfesor',
            'idProfesor0.idUsuario0.nombre',
            'idProfesor0.idUsuario0.paterno',
            'idProfesor0.idUsuario0.materno',
            'nivelEstudios',
            'especialidad',
            [
                'attribute' => 'enComite',
                'filter' => Html::activeDropDownList($searchModel, 'enComite', ['0' => 'NO', '1' => 'SI'], ['class' => 'form-control', 'prompt' => 'Cualquiera']),
                'value' => function($model, $key, $index, $grid) {
                    return ($model->enComite == 1) ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
                },
                'format' => 'html',
                'contentOptions' => [
                    'style' => 'vertical-align:middle',
                    'align' => 'center'
                ]
            ],
            [
                'attribute' => 'enIntegradora',
                'filter' => Html::activeDropDownList($searchModel, 'enIntegradora', ['0' => 'NO', '1' => 'SI'], ['class' => 'form-control', 'prompt' => 'Cualquiera']),
                'value' => function($model, $key, $index, $grid) {
                    return ($model->enIntegradora == 1) ? '<span class="glyphicon glyphicon-ok text-success"></span>' : '<span class="glyphicon glyphicon-remove text-danger"></span>';
                },
                'format' => 'html',
                'contentOptions' => [
                    'style' => 'vertical-align:middle',
                    'align' => 'center'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{select}',
                'buttons' => [
                    'select' => function($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-check"></span>', ['class' => 'btn btn-link seleccionador', 'onclick' => 'addProfesor(' . $key . ')']);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>
