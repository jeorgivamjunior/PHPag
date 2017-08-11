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

        if (!$this->load($get)) {
            $today = date('Y-m-d');
            $where = " WHERE pay_or_receive = $filter[pay_or_receive] AND due >= '$today' ORDER BY due";
            return $bill->findAll($where, true);
        }

        $m = explode('/', $this->due);
        $due = $m[1] . '-' . $m[0];
        $today = date('Y-m');
        if ($today < $due) {
            $recurrent = new Recurrent();
            $recurrent = $recurrent->findAll();

            $bill_ids = [];
            /** @var Recurrent $item */
            foreach ($recurrent as $item) {
                if ($item->period == '' || is_null($item->period)) {
                    $bill_ids[] = $item->bill_id;
                } else {
                    $model = new Bill();
                    $model->findOne($item->bill_id);
                    $date = date('Y-m-d', strtotime($model->due . "+$item->period months"));
                    $inMothYear = date('Y-m', strtotime($date));
                    if ($due <= $inMothYear) {
                        $bill_ids[] = $model->id;
                    }
                }
            }

            $where = " WHERE id IN (" . implode(',', $bill_ids) . ") AND pay_or_receive=$this->pay_or_receive ORDER BY due";
        } else {
            $where = " WHERE due LIKE '$due%' AND pay_or_receive=$this->pay_or_receive ORDER BY due";
        }
        return $bill->findAll($where, true);
    }
}