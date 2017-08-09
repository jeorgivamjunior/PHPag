<?php

namespace models;

use config\DataBase;

class Bill extends DataBase
{
    public $name;
    public $category_id;
    public $price;
    public $due;
    public $total;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'price'], 'integer'],
            [['name'], 'string'],
            [['due', 'total'], 'safe']
        ];
    }

    public function getTableName()
    {
        return "bill";
    }

    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
            'category_id' => 'Categoria',
            'price' => 'Preço',
            'due' => 'Data de Vencimento',
            'total' => 'Total (R$)'
        ];

        return $labels[$attr];
    }
}