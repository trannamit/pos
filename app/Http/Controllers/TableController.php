<?php

namespace App\Http\Controllers;

use DB;

class TableController
{

    public function showTable($id)
    {
        return view('table.index', [
            'id' => $id,
        ]);
    }



    public function getMenuList()
    {
        return DB::table('menu')
            ->where('active', 'Active')
            ->where('deleted_at', null)
            ->select('id', 'product_name as text', 'price as value')
            ->get();
    }

    public function getTableInfor()
    {
        $input = request('id');
        return DB::table('table_item as t')
            ->where([
                ['p.bill_id', null],
                ['t.id', $input]
            ])
            ->leftJoin('product_in_table as p', 't.id', 'p.table_id')
            ->leftJoin('menu as m', 'p.product_id', 'm.id')
            ->select(
                'm.product_name as product_name',
                'm.id as product_id',
                'm.price as price',
                't.name_table as name_table',
                't.table_number as table_number',
                'p.note as note',
                'p.id as item_id',
                'p.cashier_id as cashier_id',
            )
            ->get();
    }

    public function saveUpdateTable()
    {
        $input = request()->all();
        /* dd($input); */

        $validation = validator($input, [
            'table_id'         =>    'required|max:10',
            'table_name'       =>    'required|max:100',
        ]);
        if ($validation->fails()) {
            return ['code' => 'ERROR', 'messages' => 'Thiếu thông tin về bàn', 'error' => $validation->errors()];
        }
        $table_id = $input['table_id'];
        $table_name = $input['table_name'];
        if (isset($input['listUpdateItems'])) {
            $list_update = $input['listUpdateItems'];
            foreach ($list_update as $update) {
                $validation = validator($update, [
                    'product_id' => 'required|max:10',
                    'note'       => 'max:191',
                ]);
                if ($validation->fails()) {
                    return ['code' => 'ERROR', 'messages' => 'Thiếu thông tin về item cập nhật', 'error' => $validation->errors()];
                }
            }
            $insert = array();
            $insertNew = array();
            $list_id = array();
            foreach ($list_update as $update) {
                if (empty($update['item_id'])) {
                    $t1 = [
                        'table_id' => $table_id,
                        'product_id' => $update['product_id'],
                        'note' => $update['note'],
                        'creater_id' => auth()->user()->user_id,
                        'created_at' => now(),
                    ];
                    array_push($insertNew, $t1);
                } else {
                    $t = [
                        'id' => $update['item_id'],
                        'table_id' => $table_id,
                        'product_id' => $update['product_id'],
                        'note' => $update['note'],
                        'creater_id' => auth()->user()->user_id,
                        'created_at' => now(),
                    ];
                    array_push($insert, $t);
                    array_push($list_id, $update['item_id']);
                }
            }
        }

        DB::beginTransaction();
        try {
            if (isset($insert)) {
                DB::table('product_in_table')
                    ->whereIn('id', $list_id)
                    ->delete();
                DB::table('product_in_table')
                    ->insert($insert);
            }
            if (isset($insertNew)) {
                DB::table('product_in_table')
                    ->insert($insertNew);
            }

            DB::table('table_item')
                ->where('id', $table_id)
                ->update(['name_table' => $table_name]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'messages' => $e->errorInfo];
        }
        DB::commit();
        return ['code' => 'SUCCESS'];
    }

    public function deleteItems()
    {
        $input = request()->all();
        /* dd($input); */
        $list = $input['list'];
        $lId = array();
        $lLog = array();
        $reason_delete = $input['reason_delete'];

        foreach ($list as $itm) {
            array_push($lId, $itm['id']);
            array_push($lLog, [
                'description' => 'Đã xoá [' . $itm['product_name'] . '] lý do :[' . $reason_delete . '] ',
                'table_id' => $itm['table_id'],
                'created_at' => now(),
                'creater_id' => auth()->user()->user_id,
            ]);
        }

        DB::beginTransaction();
        try {
            DB::table('product_in_table')
                ->whereIn('id', $lId)
                ->delete();
            DB::table('log')
                ->insert($lLog);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'messages' => $e->errorInfo];
        }
        DB::commit();
        return ['code' => 'SUCCESS'];
    }

    public function payItems()
    {
        $input = request()->all();
        /* dd($input); */
        $listItems = $input['pay_items'];
        $table_id = $input['table_id'];
        $total_price = 0;
        $list_id = array();

        foreach ($listItems as $item) {
            $total_price += $item['price'];
            array_push($list_id, $item['item_id']);
        }

        $id = -1;
        DB::beginTransaction();
        try {
            $id = DB::table('bill')
                ->insertGetId([
                    'table_id'  =>  $table_id,
                    'creater_id' => auth()->user()->user_id,
                    'total_price' => $total_price,
                    'created_at' => now(),
                ]);

            DB::table('product_in_table')
                ->whereIn('id', $list_id)
                ->update([
                    'paid_at' => now(),
                    'cashier_id' => auth()->user()->user_id,
                    'bill_id' => $id,
                ]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'messages' => $e->errorInfo];
        }
        DB::commit();
        return ['code' => 'SUCCESS', 'id' => $id];
    }

    public function deleteTable()
    {
        $input = request('id');

        try {
            DB::table('table_item')->where('id', $input)->update([
                'deleted_at' => now(),
            ]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'message' => $e->errorInfo];
        }
        return ['code' => 'SUCCESS'];
    }
}
