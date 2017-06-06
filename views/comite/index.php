<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchComite */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Comites';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comite-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Comite', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'idComite',
            [
                'attribute' => 'idDivision',
                'value' => function($model, $key, $index, $grid){
                    return $model->idDivision0->nombre;
                },
                'filter' => Html::activeDropDownList($searchModel, 'idDivision', \app\models\Division ::listaDivisionesCombo(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
                
            ],
            'nombre',
            'descripcion',
            [
                'attribute' => 'periodoC',
                'value' => function($model, $key, $index, $grid){
                    return Utilerias::getNombreMes($model->idPeriodo0->mesInicio) . ' - ' . Utilerias::getNombreMes($model->idPeriodo0->mesFin) . ' ' . $model->idPeriodo0->anio;
                },
                'label' => 'Periodo',
                'filter' => Html::activeDropDownList($searchModel, 'idPeriodo', \app\models\Periodo::mapeaPeriodos(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
