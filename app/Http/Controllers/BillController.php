<?php

namespace App\Http\Controllers;

use DB;

class BillController
{

    public function index()
    {
        return view('bill.index', [
            'title' => 'Thống kê hoá đơn bán ra',
        ]);
    }

    public function getDataBills()
    {
        $input = request()->all();
        $day_start = $input['day_start'];
        $day_end = $input['day_end'];
        /* dd([$day_start . " 00:00:00", $day_end . " 23:59:59"]); */
        return DB::table('bill as b')
            ->whereBetween('b.created_at', [$day_start . " 00:00:00", $day_end . " 23:59:59"])
            ->join('table_item as t', 'b.table_id', 't.id')
            ->join('users as u', 'b.creater_id', 'u.user_id')
            ->select('b.*', 't.table_number as table_number', 't.name_table as table_name', 'u.name as creater')
            ->get();
    }

    public function showBill($id)
    {
        $result = DB::table('bill as b')
            ->where('b.id', $id)
            ->join('product_in_table as p', 'b.id', 'p.bill_id')
            ->join('users as u', 'b.creater_id', 'u.user_id')
            ->join('menu as m', 'p.product_id', 'm.id')
            ->join('table_item as t', 'b.table_id', 't.id')
            ->select(DB::raw('count(p.id) as total_item, sum(m.price) as total_price_bill ,b.total_price as total_price 
            , m.product_name as product_name , m.price as price, u.name as name, t.table_number as table_number, p.table_id as table_id, b.created_at as created_at'))
            ->groupBy('m.product_name')
            ->get();

        $total_item_inTable = DB::table('product_in_table')->where('table_id',$result[0]->table_id)->count();
        $total_item_inBill = 0;
        foreach ($result as $row) {
            $total_item_inBill += $row->total_item;
        }


        return view('bill.bill', [
            'title' => 'Hoá đơn số ' . $id,
            'id' => $id,
            'data' => $result,
            'creater' => $result[0]->name,
            'table_number' => $result[0]->table_number,
            'total_price' => $result[0]->total_price,
            'created_at' => $result[0]->created_at,
            'total_item_inBill' => $total_item_inBill,
            'total_item_inTable' => $total_item_inTable,
        ]);
    }
}
