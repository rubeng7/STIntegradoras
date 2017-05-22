<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\models\Utilerias;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchComite */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="comite-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'comite-index-modal',
        'pjax' => 'true',
        'pjaxSettings' => [
            'options' => [
                'enablePushState' => false
            ]
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'idComite',
            'nombre',
            'descripcion',
            [
                'attribute' => 'periodoC',
                'value' => function($model, $key, $index, $grid) {
                    return Utilerias::getNombreMes($model->idPeriodo0->mesInicio) . ' - ' . Utilerias::getNombreMes($model->idPeriodo0->mesFin) . ' ' . $model->idPeriodo0->anio;
                },
                'label' => 'Periodo',
                'filter' => Html::activeDropDownList($searchModel, 'idPeriodo', \app\models\Periodo::mapeaPeriodos(), ['class' => 'form-control', 'prompt' => 'Cualquiera'])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{select}',
                'buttons' => [
                    'select' => function($url, $model, $key) {
                        return Html::button('<span class="glyphicon glyphicon-check"></span>', ['class' => 'btn btn-link seleccionador', 'onclick' => 'addComite(' . $key . ')']);
                    }
                ]
            ],
        ],
    ]);
    ?>
</div>
