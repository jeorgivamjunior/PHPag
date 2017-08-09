<?php

namespace models;

use config\DataBase;

class Request extends DataBase
{
    public $user_id;
    public $created_at;
    public $updated_at;
    public $total;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function getTableName()
    {
        return "request";
    }

    /**
     * @return Product[]
     */
    public function getProducts()
    {
        $products = [];
        $requestHasProducts = new RequestHasProduct();
        $relations = $requestHasProducts->findAll(['request_id' => $this->id]);

        foreach ($relations as $relation) {
            $product = new Product();
            $product = $product->findOne($relation->product_id);
            $product->amount = $relation->amount;
            $products[] = $product;
        }
        return $products;
    }
}