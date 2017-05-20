<?php

use yii\helpers\Html;
use yii\widgets\Menu;
use yii\widgets\Breadcrumbs;
use app\themes\adminLTE\components\ThemeNav;
use meysampg\treeview\Treeview;
?>
<?php $this->beginContent('@app/themes/adminLTE/layouts/main.php'); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?php echo Yii::$app->request->baseUrl; ?>/images/user_accounts.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>
                    <?php
                    $info[] = Yii::t('app', 'Hello');

                    if (isset(Yii::$app->user->identity->username))
                        $info[] = ucfirst(\Yii::$app->user->identity->username);

                    echo implode(', ', $info);
                    ?>
                </p>
                <a><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->

        <?php
        
        echo Menu::widget([
            'encodeLabels' => false,
            'options' => [
                'class' => 'sidebar-menu'
            ],
            'items' => [
                ['label' => Yii::t('app', 'MENU GENERAL'), 'options' => ['class' => 'header']],
                ['label' => ThemeNav::link(' Home', 'fa fa-dashboard'), 'url' => ['site/index'], 'visible' => true],
                [
                    'label' => ThemeNav::link(' Estructura escolar', 'fa fa-dashboard'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => ThemeNav::link(' Divisiones', 'fa fa-dashboard'),
                            'url' => ['division/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Carreras', 'fa fa-dashboard'),
                            'url' => ['carrera/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Grupos', 'fa fa-users'),
                            'url' => ['grupo/index'],
                        ],
                    ],
                    'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>'
                ],
                [
                    'label' => ThemeNav::link(' Asesorias', 'fa fa-diamond'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => ThemeNav::link(' Profesores', 'fa fa-dashboard'),
                            'url' => ['profesor/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Comites', 'fa fa-dashboard'),
                            'url' => ['comite/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Esquemas', 'fa fa-users'),
                            'url' => ['esquema/index'],
                        ],
                    ],
                    'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>'
                ],
                [
                    'label' => ThemeNav::link(' Asesorados', 'fa fa-graduation-cap'),
                    'url' => '#',
                    'items' => [
                        [
                            'label' => ThemeNav::link(' Alumnos', 'fa fa-dashboard'),
                            'url' => ['alumno/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Equipos', 'fa fa-dashboard'),
                            'url' => ['equipo/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Proyectos', 'fa fa-users'),
                            'url' => ['proyecto/index'],
                        ],
                        [
                            'label' => ThemeNav::link(' Empresas', 'fa fa-users'),
                            'url' => ['empresa/index'],
                        ],
                    ],
                    'submenuTemplate' => '<ul class="treeview-menu">{items}</ul>'
                ],
                ['label' => ThemeNav::link(' Usuarios', 'fa fa-user'), 'url' => ['usuario/index'], 'visible' => true],
            ],
        ]);
        ?>

    </section>
    <!-- /.sidebar -->
</aside>

<!-- Right side column. Contains the navbar and content of the page -->
<div class="content-wrapper" style="background-color: #fff">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <!--<h1> <?php //echo Html::encode($this->title); ?> </h1>-->
        <?=
        Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ])
        ?>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php echo $content; ?>
    </section><!-- /.content -->

</div><!-- /.right-side -->
<?php
$this->endContent();
