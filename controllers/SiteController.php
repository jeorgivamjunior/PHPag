<?php

namespace controllers;

use models\LoginForm;

class SiteController
{
    public static function login()
    {
        $model = new LoginForm();

        if ($model->load() && $model->login()) {
            header("location:/construPHP/product/index");
        }

        return [
            'model' => $model
        ];
    }

    public static function logout()
    {
        if (isset($_SESSION['userLogged']))
            unset($_SESSION['userLogged']);

        header("location:/construPHP/site/login");
    }
}