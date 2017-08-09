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
    <base href="/PHPag/">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHPag</title
<body>
<?php if (isset($_SESSION['userLogged'])): ?>
    <ul class="nav navbar-nav">
        <li>
            <a href="category/index">
                Categorias
            </a>
        </li>
        <li>
            <a href="bill/index">
                Contas
            </a>
        </li>
        <li>
            <a href="user/index">
                Usuários
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
<?php endif; ?>
<div class="container-fluid">
    <?php

    Route::generate();

    ?>
</div>
</body>
</html>
