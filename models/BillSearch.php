<?php

namespace models;

class BillSearch extends Bill
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['due'], 'required'],
            [['category_id', 'paid', 'pay_or_receive', 'recurrent', 'period'], 'integer'],
            [['name', 'due', 'total'], 'string'],
            [['recurrent', 'period'], 'relation']
        ];
    }

    public function search($filter = [])
    {
        $bill = new Bill();
        $get = $_GET;
        $get = array_merge($filter, $get);

        if (!$this->load($get))
            return $bill->findAll($filter);

        $m = explode('/', $this->due);
        $due = $m[1] . '-' . $m[0];
        $where = " WHERE due LIKE '$due%' AND pay_or_receive=$this->pay_or_receive";
        return $bill->findAll($where, true);
    }
}