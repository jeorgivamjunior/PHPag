<?php

namespace models;

use config\DataBase;

/**
 * Class Category
 * @package models
 * @property integer $id
 * @property string $name
 */
class Category extends DataBase
{
    public $name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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

    public function beforeSave()
    {
        // TODO: Implement beforeSave() method.
    }

    public function afterSave($insert)
    {
        // TODO: Implement afterSave() method.
    }
}