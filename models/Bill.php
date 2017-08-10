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
        if ($this->recurrent) {
            $recurrent = new Recurrent();
            $recurrent->bill_id = $this->id;
            $recurrent->period = $this->period;
            var_dump($recurrent);
            $recurrent->save();
        }
    }

    public function beforeSave()
    {
        // TODO: Implement beforeSave() method.
    }
}