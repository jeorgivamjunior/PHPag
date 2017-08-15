<?php

namespace controllers;

use models\LoginForm;

/**
 * Class SiteController
 * @package controllers
 * Handles Site Controller
 */
class SiteController
{
    /**
     * Handles users login
     * @return array
     */
    public static function login()
    {
        $model = new LoginForm();

        if ($model->load() && $model->login()) {
            header("location:/PHPag/bill/index");
        }

        return [
            'model' => $model
        ];
    }

    /**
     * Handles users logout
     */
    public static function logout()
    {
        if (isset($_SESSION['userLogged']))
            unset($_SESSION['userLogged']);

        header("location:/PHPag/site/login");
    }

    /**
     * Display Home
     * @return array
     */
    public static function index()
    {
        return [];
    }
}