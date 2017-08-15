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
            $where = " INNER JOIN bill_detail ON bill.id=bill_detail.bill_id WHERE pay_or_receive = $filter[pay_or_receive] AND due >= '$today' ORDER BY due";
            return $bill->findAll($where, true);
        }

        $m = explode('/', $this->due);
        $due = $m[1] . '-' . $m[0];
        $today = date('Y-m');
        if ($today < $due) {
            $bills = new Bill();
            $where = " INNER JOIN bill_detail ON bill.id=bill_detail.bill_id WHERE pay_or_receive = $filter[pay_or_receive] AND due >= '$today' ORDER BY due";
            $bills = $bills->findAll($where, true);
            $billsArr = [];
            /** @var Bill $bill */
            foreach ($bills as $bill) {
                $detail = (new BillDetail())->findOne(" WHERE bill_id=$bill->id ORDER BY due DESC", true);
                if (is_null($bill->period) || $bill->period == '') {
                    if (date('Y-m', strtotime($detail->due)) != $due) {
                        $detail = (new BillDetail())->findOne(" WHERE bill_id=$bill->id ORDER BY due", true);
                    }
                    $month = $bill->period - 1;
                    $date = date('Y-m-d', strtotime($detail->due . "+$month months"));
                    $inMothYear = date('Y-m', strtotime($date));
                    if ($due > $inMothYear) {
                        continue;
                    }
                }

                $bill->paid = $detail->paid;
                $bill->total = $detail->total;
                $bill->due = $detail->due;
                $billsArr[] = $bill;
            }

            return $billsArr;
        } else {
            $where = " INNER JOIN bill_detail ON bill.id=bill_detail.bill_id WHERE due LIKE '$due%' AND pay_or_receive=$this->pay_or_receive ORDER BY due";
        }

        return $bill->findAll($where, true);
    }
}