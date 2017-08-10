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
            'billsFiltered' => $billsFiltered,
            'category' => $category
        ];
    }

    public static function pay()
    {
        $model = new Bill();
        $model->pay_or_receive = 0;
        $category = new Category();
        $categories = $category->findAll();

//        if ($model->load() && $model->save()) {
        if ($model->load()) {
            var_dump($model);
//            header("location:/PHPag/bill/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    public static function receive()
    {
        $model = new Bill();
        $model->pay_or_receive = 1;
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
//            header("location:/PHPag/bill/index");
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