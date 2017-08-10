<?php

namespace models;

use config\DataBase;

/**
 * Class Recurrent
 * @package models
 * @property integer $bill_id
 * @property string $period
 */
class Recurrent extends DataBase
{
    public $bill_id;
    public $period;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id'], 'required'],
            [['bill_id', 'period'], 'integer']
        ];
    }

    public function getTableName()
    {
        return "recurrent";
    }

    public function getLabel($attr)
    {
        $labels = [
        ];

        return $labels[$attr];
    }
}