<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProfesor */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Profesores';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profesor-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Profesor', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
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
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
