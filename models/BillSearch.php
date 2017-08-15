<?php

namespace models;

/**
 * Class BillSearch
 * @package models
 * Handles the BillSearch model
 */
class BillSearch extends Bill
{
    /**
     * Handles rules for the model attributes
     * @return array
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

    /**
     * Handles search form
     * @param array $filter
     * @return array
     */
    public function search($filter = [])
    {
        $bill = new Bill();
        $get = $_GET;
        $get = array_merge($filter, $get);
        $today = date('Y-m-d');
        $query = "SELECT bill.*, due, paid, total FROM bill INNER JOIN bill_detail ON bill.id=bill_detail.bill_id WHERE pay_or_receive = $filter[pay_or_receive] AND due >= '$today' ORDER BY due";
        $bills = (new Bill())->findAllBySql($query);

        if (!$this->load($get)) {
            return $bills;
        }

        $m = explode('/', $this->due);
        $due = $m[1] . '-' . $m[0];
        $today = date('Y-m');
        if ($today < $due) {
            $billsArr = [];
            /** @var Bill $bill */
            foreach ($bills as $bill) {
                $detail = (new BillDetail())->findOne(" WHERE bill_id=$bill->id ORDER BY due DESC", true);
                if (!is_null($bill->period) && $bill->period != '0') {
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

    public function searchByRange($filter = [])
    {
        $today = date('Y-m-d');
        $future = date('Y-m-d', strtotime($today . "+1 months"));
        $query = "SELECT bill.*, due, paid, total FROM bill INNER JOIN bill_detail ON bill.id=bill_detail.bill_id WHERE pay_or_receive = $filter[pay_or_receive] AND due BETWEEN '$today' AND '$future' ORDER BY due";
        $bills = (new Bill())->findAllBySql($query);

        $billsArr = [];
        /** @var Bill $bill */
        foreach ($bills as $bill) {
            $detail = (new BillDetail())->findOne(" WHERE bill_id=$bill->id ORDER BY due DESC", true);
            if (!is_null($bill->period) && $bill->period != '0') {
                if ($detail->due > $future) {
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

    }
}