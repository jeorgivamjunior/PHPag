<?php

namespace models;

use config\DataBase;

class Bill extends DataBase
{
    public $name;
    public $category_id;
    public $period;
    public $pay_or_receive;

    public $total;
    public $paid;
    public $due;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'due', 'total', 'category_id'], 'required'],
            [['category_id', 'paid', 'pay_or_receive', 'period'], 'integer'],
            [['name', 'due', 'total'], 'string'],
            [['total', 'paid', 'due'], 'relation']
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
            'total' => 'Total(R$)',
            'paid' => 'Pago',
            'period' => "Duração em meses"
        ];

        return $labels[$attr];
    }

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

        if ($isNew)
            $billDetail->save();
        else
            $billDetail->update();

        parent::afterSave($insert);
    }
}