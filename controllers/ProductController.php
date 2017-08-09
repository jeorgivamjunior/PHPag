<?php

namespace controllers;

use models\Category;
use models\Product;

class ProductController
{
    public static function index()
    {
        $product = new Product();
        $models = $product->findAll();
        $category = new Category();

        $productsFiltered = [];

        /** @var Product $product */
        foreach ($models as $product) {
            $productsFiltered[$product->category_id][] = $product;
        }

        return [
            'models' => $models,
            'productsFiltered' => $productsFiltered,
            'category' => $category
        ];
    }

    public static function create()
    {
        $model = new Product();
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
            header("location:/construPHP/product/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    public static function update()
    {
        $product = new Product();
        $model = $product->findOne($_GET['id']);
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->update()) {
            header("location:/construPHP/product/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }


    public static function delete()
    {
        $product = new Product();
        $model = $product->findOne($_GET['id']);
        $model->delete();
        header("location:/construPHP/product/index");
    }
}