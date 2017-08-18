<?php

namespace controllers;

use config\Main;
use models\BillDetail;
use models\BillSearch;
use models\Category;
use models\Bill;

/**
 * Class BillController
 * @package controllers
 * Handles Bill Controller
 */
class BillController
{
    /**
     * List all models
     * @return array
     */
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
            $billsToPayFiltered[$bill->category_id][] = $bill;
        }

        /** @var Bill $bill */
        foreach ($modelsToReceive as $bill) {
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

    /**
     * Handles bills of pay type
     * @return array
     */
    public static function pay()
    {
        $model = new Bill();
        $model->pay_or_receive = 0;
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "bill/index");
        }
        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    /**
     * Handles bills of receive type
     * @return array
     */
    public static function receive()
    {
        $model = new Bill();
        $model->pay_or_receive = 1;
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->save()) {
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "bill/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    /**
     * Update model
     * @return array
     */
    public static function update()
    {
        $bill = new Bill();
        list($id, $due) = explode('/', base64_decode($_GET['id']));
        $model = $bill->findOne($id);
        $model->due = $due;
        $model->loadDetail();
        $category = new Category();
        $categories = $category->findAll();

        if ($model->load() && $model->update()) {
            header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "bill/index");
        }

        return [
            'model' => $model,
            'categories' => $categories
        ];
    }

    /**
     * Delete model
     */
    public static function delete()
    {
        list($id, $due) = explode('/', base64_decode($_GET['id']));

        $model = (new BillDetail())->findOne(['bill_id' => $id, 'due' => $due]);
        $model->delete();
        header("location:/" . ((Main::$general['dirBase'] == '/') ? '' : Main::$general['dirBase'] . "/") . "bill/index");
    }
}