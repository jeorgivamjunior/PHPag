<?php

use config\Main;

ob_start();
session_start();

function __autoload($class_name)
{
    $filename = str_replace('\\', DIRECTORY_SEPARATOR, $class_name) . '.php';

    require $filename;
}

use components\Route;

?>
<!doctype html>
<html lang="en">
<head>
    <base href="/<?= ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") ?>">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHPag</title>

    <!-- Bootstrap -->
    <link href="node_modules/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="node_modules/gentelella/build/css/custom.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

    <!-- jQuery -->
    <script src="node_modules/gentelella/vendors/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/gentelella/vendors/Chart.js/dist/Chart.min.js"></script>

<body class="<?= (isset($_SESSION['userLogged'])) ? 'nav-md' : 'login' ?>">
<?php if (isset($_SESSION['userLogged'])): ?>
    <div class="container body">
        <div class="main_container">

            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a href="./" class="site_title">
                            <i class="fa fa-money"></i>
                            <span>PHPag</span>
                        </a>
                    </div>

                    <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img src="assets/img/avatar.png" alt="avatar" class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Bem vindo,</span>
                            <h2><?= $_SESSION['userLogged']->name ?></h2>
                        </div>
                    </div>
                    <!-- /menu profile quick info -->

                    <br/>
                    <!-- sidebar menu -->
                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
                            <h3>Menu</h3>
                            <ul class="nav side-menu">
                                <li>
                                    <a href="site/index">
                                        <i class="fa fa-home"></i>
                                        Home
                                    </a>
                                </li>
                                <li>
                                    <a href="category/index">
                                        <i class="fa fa-filter"></i>
                                        Categorias
                                    </a>
                                </li>
                                <li>
                                    <a href="bill/index">
                                        <i class="fa fa-money"></i>
                                        Contas
                                    </a>
                                </li>
                                <li>
                                    <a href="user/index">
                                        <i class="fa fa-users"></i>
                                        Usuários
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- sidebar menu -->
                </div>
            </div>

            <!-- top navigation -->
            <div class="top_nav">
                <div class="nav_menu">
                    <nav>
                        <div class="nav toggle">
                            <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                        </div>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="">
                                <a href="javascript:;" class="user-profile dropdown-toggle"
                                   data-toggle="dropdown" aria-expanded="false">
                                    <img src="assets/img/avatar.png" alt="">
                                    <?= $_SESSION['userLogged']->name ?>
                                    <span class=" fa fa-angle-down"></span>
                                </a>
                                <ul class="dropdown-menu dropdown-usermenu pull-right">
                                    <li>
                                        <a href="site/logout">
                                            <i class="fa fa-sign-out pull-right"></i>
                                            Sair
                                        </a>
                                    </li>
                                </ul>
                            </li>

                        </ul>
                    </nav>
                </div>
            </div>
            <!-- /top navigation -->


            <!-- page content -->
            <div class="right_col" role="main">
                <?php

                Route::generate();

                ?>
            </div>

            <!-- footer content -->
            <footer>
                <div class="pull-right">
                    ©2017 All Rights Reserved.
                </div>
                <div class="clearfix"></div>
            </footer>
            <!-- /footer content -->
        </div>
    </div>
<?php else: ?>
    <?php
    Route::generate();
    ?>
<?php endif; ?>

<!-- Bootstrap -->
<script src="node_modules/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="node_modules/gentelella/build/js/custom.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<!-- Custom Theme Scripts -->
<script src="node_modules/jquery-maskmoney/dist/jquery.maskMoney.min.js"></script>
</body>
</html>
