<?php

namespace models;

use config\DataBase;

class Product extends DataBase
{
    public $name;
    public $category_id;
    public $price;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price'], 'integer'],
            [['name'], 'string']
        ];
    }

    public function getTableName()
    {
        return "product";
    }

    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
            'category_id' => 'Categoria',
            'price' => 'Preço'
        ];

        return $labels[$attr];
    }
}