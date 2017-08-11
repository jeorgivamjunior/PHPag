<?php

namespace controllers;

use models\BillSearch;
use models\Category;
use models\Bill;
use models\Recurrent;

class BillController
{
    public static function index()
    {
        $modelSearchToPay = new BillSearch();
        $modelsToPay = $modelSearchToPay->search(['pay_or_receive' => 0]);

        $modelSearchToReceive = new BillSearch();
        $modelsToReceive = $modelSearchToReceive->search(['pay_or_receive' => 1]);

        $category = new Category();

        $billsToPayFiltered = [];
        $billsToReceiveFiltered = [];

        /** @var Bill $bill */
        foreach ($modelsToPay as $bill) {
            $recurrent = new Recurrent();
            $recurrent = $recurrent->findOne(['bill_id' => $bill->id]);
            $bill->recurrent = !empty($recurrent);

            $billsToPayFiltered[$bill->category_id][] = $bill;
        }

        /** @var Bill $bill */
        foreach ($modelsToReceive as $bill) {
            $recurrent = new Recurrent();
            $recurrent = $recurrent->findOne(['bill_id' => $bill->id]);
            $bill->recurrent = !empty($recurrent);

            $billsToReceiveFiltered[$bill->category_id][] = $bill;
        }

        return [
            'modelSearchToPay' => $modelSearchToPay,
            'modelsToReceive' => $modelsToReceive,
            'modelsToPay' => $modelsToPay,
            'billsToReceiveFiltered' => $billsToReceiveFiltered,
            'billsToPayFiltered' => $billsToPayFiltered,
            'category' => $category
        ];
    }

    public static function pay()
    {
        $model = new Bill();
        $model->pay_or_receive = 0;
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
            header("location:/PHPag/bill/index");
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
            header("location:/PHPag/bill/index");
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
        $recurrent = new Recurrent();
        $recurrent = $recurrent->findOne(['bill_id' => $_GET['id']]);
        $model->recurrent = !empty($recurrent);
        $model->period = (empty($recurrent)) ? "" : $recurrent->period;

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
        header("location:/PHPag/bill/index");
    }
}