<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Profesor */

$this->title = 'Crear Profesor';
$this->params['breadcrumbs'][] = ['label' => 'Profesores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//echo ($valid == true) ? 'si es valido' : 'no es valido';
?>
<div class="profesor-create">

    <div class="page-header"><h1><?= Html::encode($this->title) ?></h1></div>

    <?=
    $this->render('_form', [
        'model' => $model,
        'persona' => $persona,
        'usuario' => $usuario,
        'profesorGrupoPeriodos' => $profesorGrupoPeriodos,
    ])
    ?>

</div>
