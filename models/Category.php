<?php

namespace models;

use config\DataBase;

class Category extends DataBase
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string']
        ];
    }

    public function getTableName()
    {
        return "category";
    }

    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
        ];

        return $labels[$attr];
    }
}