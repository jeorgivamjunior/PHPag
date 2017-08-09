<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
    <base href="/construPHP/">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ConstruPHP</title>

    <!-- Material Design fonts -->
    <link rel="stylesheet" type="text/css" href="css/font-family.css">
    <link rel="stylesheet" type="text/css" href="css/icon.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">

    <!-- Bootstrap Material Design -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap-material-design.css">
    <link rel="stylesheet" type="text/css" href="css/ripples.min.css">

    <script src="js/jquery-3.2.1.js"></script>
    <script src="js/material.js"></script>
    <script src="js/ripples.js"></script>

    <script>
        $.material.init();
    </script>
</head>
<body>
<?php if (isset($_SESSION['userLogged'])): ?>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="">ConstruPHP</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="category/index">
                            Categorias
                        </a>
                    </li>
                    <li>
                        <a href="product/index">
                            Produtos
                        </a>
                    </li>
                    <li>
                        <a href="user/index">
                            Usuários
                        </a>
                    </li>
                    <li>
                        <a href="request/index">
                            Orçamentos
                        </a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right">
                        <a href="site/logout">
                            Sair
                        </a>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
<?php endif; ?>
<div class="container-fluid">
    <?php

    Route::generate();

    ?>
</div>
</body>
</html>
