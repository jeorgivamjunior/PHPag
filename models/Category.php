<?php

namespace models;

use config\DataBase;

/**
 * Class Category
 * @package models
 * @property integer $id
 * @property string $name
 * Handles the Category model
 */
class Category extends DataBase
{
    public $name;

    /**
     * Handles rules for the model attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string']
        ];
    }

    /**
     * Get the table name
     * @return string
     */
    public function getTableName()
    {
        return "category";
    }

    /**
     * Get label from model
     * @param $attr
     * @return mixed
     */
    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
        ];

        return $labels[$attr];
    }
}