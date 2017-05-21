<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Grupo;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchAlumno */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="alumno-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Alumno', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'idAlumno',
            'matricula',
            'idAlumno0.idUsuario0.nombre',
            'idAlumno0.idUsuario0.paterno',
            'idAlumno0.idUsuario0.materno',
            [
                'attribute' => 'cuatrimestre',
                'filter' => Html::activeDropDownList($searchModel, 'cuatrimestre', Grupo::ARRAY_CUATRIMESTRES, ['class' => 'form-control', 'prompt' => 'Cualquiera']),
            ],
            [
                'attribute' => 'letra',
                'filter' => Html::activeDropDownList($searchModel, 'letra', Grupo::ARRAY_GRUPOS, ['class' => 'form-control', 'prompt' => 'Cualquiera']),
                'label' => 'Grupo',
            ],
            [
                'attribute' => 'turno',
                'filter' => Html::activeDropDownList($searchModel, 'turno', Grupo::ARRAY_TURNOS, ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'attribute' => 'periodo',
                'value' => function($model, $key, $index, $grid){
                    //$periodoC = app\models\Periodo::findOne($searchModel['periodo']);
                    //return Utilerias::getNombreMes($periodoC->mesInicio) . ' - ' . Utilerias::getNombreMes($periodoC->mesFin) . ' ' . $periodoC->anio;
                    return $model['periodo'];
                },
                'label' => 'Periodo',
                'filter' => Html::activeDropDownList($searchModel, 'periodo', \app\models\Periodo::mapeaPeriodos(), ['class' => 'form-control',])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
