<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SearchEmpresa */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="empresa-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Crear Empresa', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idEmpresa',
            'nombre',
            'giro',
            'responsable',
            'telefono',
            [
                'attribute' => 'direccionCompleta',
                'label' => 'Dirección',
                'value' => function ($model, $key, $index, $column) {
                    $direccion = $model->idDireccion0;
                    return $direccion->calle . ' ' . $direccion->numero . ' ' .
                            $direccion->ciudad . ' ' . $direccion->municipio . ' ' .
                            $direccion->estado . ' CP: ' . $direccion->cp;
                }
            ],
            // 'idDireccion',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
