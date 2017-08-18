<?php

namespace controllers;

use config\Main;
use models\User;

/**
 * Class UserController
 * @package controllers
 * Handles User Controller
 */
class UserController
{
    /**
     * List all models
     * @return array
     */
    public static function index()
    {
        $product = new User();
        $models = $product->findAll();

        return [
            'models' => $models,
        ];
    }

    /**
     * Create a model
     * @return array
     */
    public static function create()
    {
        $model = new User();

        if ($model->load() && $model->save()) {
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "user/index");
        }

        return [
            'model' => $model,
        ];
    }

    /**
     * Update model
     * @return array
     */
    public static function update()
    {
        $user = new User();
        $model = $user->findOne($_GET['id']);

        if ($model->load() && $model->update()) {
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "user/index");
        }

        return [
            'model' => $model,
        ];
    }

    /**
     * Delete model
     */
    public static function delete()
    {
        $user = new User();
        $model = $user->findOne($_GET['id']);
        $model->delete();
        header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "user/index");
    }
}