<?php

namespace models;

use config\DataBase;

class BillDetail extends DataBase
{
    public $bill_id;
    public $total;
    public $paid;
    public $due;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['due', 'total', 'bill_id'], 'required'],
            [['due'], 'string'],
            [['paid', 'bill_id'], 'integer'],
        ];
    }

    public function getTableName()
    {
        return "bill_detail";
    }

    public function getLabel($attr)
    {
        $labels = [
        ];

        return $labels[$attr];
    }
}