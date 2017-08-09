<?php

namespace models;

use config\DataBase;

class RequestHasProduct extends DataBase
{
    public $product_id;
    public $request_id;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['request_id', 'product_id', 'amount'], 'integer']
        ];
    }

    public function getTableName()
    {
        return "request_has_product";
    }
}