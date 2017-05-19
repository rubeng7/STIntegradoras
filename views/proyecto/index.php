<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchProyecto */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Proyectos';
$this->params['breadcrumbs'][] = $this->title;

$template = '<span class="input-group-addon">
                <i class="glyphicon glyphicon-calendar"></i>
            </span>    
            <span class="form-control text-right">
                <span class="pull-left">
                    <span class="range-value" style="white-space : nowrap">{value}</span>
                </span>
                    {input}
            </span>';
?>
<div class="proyecto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a('Crear Proyecto', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'idProyecto',
            'nombre',
            // 'descripcion',
            [
                'attribute' => 'fechaInicio',
                'filterType' => kartik\grid\GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'model' => $searchModel,
                    'attribute' => 'fechaInicio',
                    'convertFormat' => true,
                    'hideInput' => true,
                    'containerTemplate' => $template,
                    'presetDropdown' => true,
                    'useWithAddon' => true,
                    'startAttribute' => 'fechaInicio1',
                    'endAttribute' => 'fechaFin1',
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd/m/Y'
                        ],
                    ],
                ],
                'value' => function ($model, $key, $index, $grid) {
                    return Utilerias::getDateNormalFromDateMysql($model->fechaInicio);
                }
            ],
            [
                'attribute' => 'limite',
                'filterType' => kartik\grid\GridView::FILTER_DATE_RANGE,
                'filterWidgetOptions' => [
                    'model' => $searchModel,
                    'attribute' => 'limite',
                    'convertFormat' => true,
                    'hideInput' => true,
                    'containerTemplate' => $template,
                    'presetDropdown' => true,
                    'useWithAddon' => true,
                    'startAttribute' => 'fechaInicio2',
                    'endAttribute' => 'fechaFin2',
                    'pluginOptions' => [
                        'locale' => [
                            'format' => 'd/m/Y'
                        ],
                        'opens' => 'left'
                    ],
                ],
                'value' => function ($model, $key, $index, $grid) {
                    return Utilerias::getDateNormalFromDateMysql($model->limite);
                }
            ],
            'idEmpresa0.nombre',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
</div>
