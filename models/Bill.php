<?php

namespace models;

use config\DataBase;

class Bill extends DataBase
{
    public $name;
    public $category_id;
    public $due;
    public $total;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
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
            'due' => 'Data de Vencimento',
            'total' => 'Total (R$)'
        ];

        return $labels[$attr];
    }
}