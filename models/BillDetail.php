<?php

namespace models;

use config\DataBase;

/**
 * Class BillDetail
 * @package models
 * * Handles BillDetail Model
 */
class BillDetail extends DataBase
{
    public $bill_id;
    public $total;
    public $paid;
    public $due;
    public $discount;

    /**
     * Handles rules for the model attributes
     * @return array
     */
    public function rules()
    {
        return [
            [['due', 'total', 'bill_id'], 'required'],
            [['due', 'discount'], 'string'],
            [['paid', 'bill_id'], 'integer'],
        ];
    }

    /**
     * Get the table name
     * @return string
     */
    public function getTableName()
    {
        return "bill_detail";
    }

    /**
     * Get label from model
     * @param $attr
     * @return mixed
     */
    public function getLabel($attr)
    {
        $labels = [
        ];

        return $labels[$attr];
    }
}