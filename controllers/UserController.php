<?php

namespace controllers;

use models\User;

class UserController
{
    public static function index()
    {
        $product = new User();
        $models = $product->findAll();

        return [
            'models' => $models,
        ];
    }

    public static function create()
    {
        $model = new User();

        if ($model->load() && $model->save()) {
            header("location:/PHPag/user/index");
        }

        return [
            'model' => $model,
        ];
    }

    public static function update()
    {
        $user = new User();
        $model = $user->findOne($_GET['id']);

        if ($model->load() && $model->update()) {
            header("location:/PHPag/user/index");
        }

        return [
            'model' => $model,
        ];
    }


    public static function delete()
    {
        $user = new User();
        $model = $user->findOne($_GET['id']);
        $model->delete();
        header("location:/PHPag/user/index");
    }
}