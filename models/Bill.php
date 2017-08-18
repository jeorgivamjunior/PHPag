<?php

namespace models;

use config\DataBase;

/**
 * Class Bill
 * @package models
 * Handles Bill Model
 */
class Bill extends DataBase
{
    public $name;
    public $category_id;
    public $period;
    public $pay_or_receive;

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
            [['name', 'due', 'total', 'category_id'], 'required'],
            [['category_id', 'paid', 'pay_or_receive', 'period'], 'integer'],
            [['name', 'due', 'total', 'discount'], 'string'],
            [['total', 'paid', 'due', 'discount'], 'relation']
        ];
    }

    /**
     * Get the table name
     * @return string
     */
    public function getTableName()
    {
        return "bill";
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
            'category_id' => 'Categoria',
            'due' => 'Data de Vencimento',
            'total' => 'Total(R$)',
            'paid' => 'Pago',
            'discount' => "Desconto",
            'period' => "Duração em meses"
        ];

        return $labels[$attr];
    }

    /**
     * Handles model after save it
     * @param $insert
     */
    public function afterSave($insert)
    {
        $billDetail = new BillDetail();
        $billDetail = $billDetail->findOne(['bill_id' => $this->id, 'due' => $this->due]);
        $isNew = false;
        if (empty($billDetail)) {
            $billDetail = new BillDetail();
            $isNew = true;
        }

        $billDetail->bill_id = $this->id;
        $billDetail->due = $this->due;
        $billDetail->total = $this->total;
        $billDetail->paid = $this->paid;
        $billDetail->discount = $this->discount;
        if ($isNew)
            $billDetail->save();
        else
            $billDetail->update();

        parent::afterSave($insert);
    }

    /**
     * Load related model
     */
    public function loadDetail()
    {
        $detail = (new BillDetail())->findOne(['bill_id' => $this->id, 'due' => $this->due]);
        $this->due = $detail->due;
        $this->total = $detail->total;
        $this->paid = $detail->paid;
    }
}