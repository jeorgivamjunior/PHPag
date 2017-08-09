<?php

namespace controllers;

use models\Category;
use models\Product;
use models\Request;
use models\RequestHasProduct;

class RequestController
{
    public static function index()
    {
        $request = new Request();
        $models = $request->findAll();

        return [
            'models' => $models,
        ];
    }

    public static function create()
    {
        $model = new Request();
        $modelProducts = [];
        $product = new Product();
        $products = $product->findAll();
        $category = new Category();
        $productsFiltered = [];

        /** @var Product $product */
        foreach ($products as $product) {
            $productsFiltered[$product->category_id][] = clone $product;
        }

        $productsFromPost = isset($_POST['Products']) ? $_POST['Products'] : [];

        if (empty($productsFromPost) && empty($post['addNewProduct'])) {
            $modelProducts = [new RequestHasProduct()];
        }

        foreach ($productsFromPost as $productFromPost) {
            $modelProduct = new RequestHasProduct();
            $modelProduct->product_id = $productFromPost['product_id'];
            $modelProduct->amount = $productFromPost['amount'];
            $modelProducts[] = $modelProduct;
        }

        if (!empty($_POST['removeProduct'])) {
            array_splice($modelProducts, $_POST['removeProductIndex'], 1);
        }

        foreach ($modelProducts as $modelProduct) {
            $result = $product->findOne($modelProduct->product_id);
            $model->total += $result->price * $modelProduct->amount;
        }

        if ($_POST && empty($_POST['addNewProduct']) && empty($_POST['Calculate']) && empty($_POST['removeProduct'])) {
            $model->user_id = $_SESSION['userLogged']->id;
            if ($model->save(['user_id', 'total'])) {
                foreach ($modelProducts as $modelProduct) {
                    $modelProduct->request_id = $model->id;
                    $modelProduct->save();
                }

                header("location:/construPHP/request/index");
            }
        }

        if (!empty($_POST['addNewProduct'])) {
            $modelProducts[] = new RequestHasProduct();
        }

        return [
            'model' => $model,
            'productsFiltered' => $productsFiltered,
            'category' => $category,
            'modelProducts' => $modelProducts
        ];
    }

    public static function delete()
    {
        $request = new Request();
        $model = $request->findOne($_GET['id']);
        $model->delete();
        header("location:/construPHP/request/index");
    }
}