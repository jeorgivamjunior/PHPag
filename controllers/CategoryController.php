<?php

namespace controllers;

use models\Category;

/**
 * Class CategoryController
 * @package controllers
 * Handles Category Controller
 */
class CategoryController
{
    /**
     * List all models
     * @return array
     */
    public static function index()
    {
        $category = new Category();
        $models = $category->findAll();

        return [
            'models' => $models
        ];
    }

    /**
     * Create a model
     * @return array
     */
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

    /**
     * Update model
     * @return array
     */
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

    /**
     * Delete model
     */
    public static function delete()
    {
        $product = new Category();
        $model = $product->findOne($_GET['id']);
        $model->delete();
        header("location:/PHPag/category/index");
    }
}