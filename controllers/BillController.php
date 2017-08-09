<?php

namespace controllers;

use models\Category;
use models\Bill;

class BillController
{
    public static function index()
    {
        $bill = new Bill();
        $models = $bill->findAll();
        $category = new Category();

        $billsFiltered = [];

        /** @var Bill $bill */
        foreach ($models as $bill) {
            $billsFiltered[$bill->category_id][] = $bill;
        }

        return [
            'models' => $models,
            'productsFiltered' => $billsFiltered,
            'category' => $category
        ];
    }

    public static function create()
    {
        $model = new Bill();
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
            header("location:/PHPag/product/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    public static function update()
    {
        $bill = new Bill();
        $model = $bill->findOne($_GET['id']);
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->update()) {
            header("location:/PHPag/bill/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }


    public static function delete()
    {
        $bill = new Bill();
        $model = $bill->findOne($_GET['id']);
        $model->delete();
        header("location:/PHPag/'/index");
    }
}