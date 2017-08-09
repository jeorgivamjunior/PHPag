<?php

namespace controllers;

use models\Category;

class CategoryController
{
    public static function index()
    {
        $category = new Category();
        $models = $category->findAll();

        return [
            'models' => $models
        ];
    }

    public static function create()
    {
        $model = new Category();

        if ($model->load() && $model->save()) {
            header("location:/PHPag/category/index");
        }

        return [
            'model' => $model
        ];
    }

    public static function update()
    {
        $category = new Category();
        $model = $category->findOne($_GET['id']);

        if ($model->load() && $model->update()) {
            header("location:/PHPag/category/index");
        }

        return [
            'model' => $model,
        ];
    }

    public static function delete()
    {
        $product = new Category();
        $model = $product->findOne($_GET['id']);
        $model->delete();
        header("location:/PHPag/category/index");
    }
}