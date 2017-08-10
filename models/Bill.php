<?php

namespace models;

use config\DataBase;

class Bill extends DataBase
{
    public $name;
    public $category_id;
    public $total;
    public $paid;
    public $due;
    public $pay_or_receive;

    public $recurrent;
    public $period;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'due', 'total', 'category_id'], 'required'],
            [['category_id', 'paid', 'pay_or_receive', 'recurrent', 'period'], 'integer'],
            [['name', 'due', 'total'], 'string'],
            [['recurrent', 'period'], 'relation']
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
            'recurrent' => 'Recorrente',
            'total' => 'Total(R$)',
            'paid' => 'Pago',
            'period' => "Duração em meses"
        ];

        return $labels[$attr];
    }

    public function afterSave($insert)
    {
        $recurrent = new Recurrent();
        $recurrent = $recurrent->findOne(['bill_id' => $this->id]);
        if ($this->recurrent) {
            if (empty($recurrent)) {
                $recurrent = new Recurrent();
                $recurrent->bill_id = $this->id;
                $recurrent->period = $this->period;
                $recurrent->save();
            }
        } else {
            if (!empty($recurrent))
                $recurrent->delete();
        }

        parent::afterSave($insert);
    }
}