<?php

namespace controllers;

use models\Bill;
use models\BillSearch;
use models\Category;
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
        $modelSearchToPay = new BillSearch();
        $modelsToPay = $modelSearchToPay->searchByRange(['pay_or_receive' => 0]);

        $modelSearchToReceive = new BillSearch();
        $modelsToReceive = $modelSearchToReceive->searchByRange(['pay_or_receive' => 1]);

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
}