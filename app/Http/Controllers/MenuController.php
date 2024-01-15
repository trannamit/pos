<?php

namespace App\Http\Controllers;

use DB;

class MenuController
{

    public function index()
    {
        return view('menu.index');
    }

    public function getAllMenu()
    {
        return DB::table('menu')
            ->select('id', 'product_name', 'price', 'active')
            ->where('deleted_at', null)
            ->get();
    }


    public function saveUpdateMenu()
    {
        $input = request('listUpdateItems');
        $listIdUpdate = array();
        $listUpdate = array();
        $listInsert = array();
        foreach ($input as $i) {
            if (isset($i['id'])) {
                array_push($listIdUpdate, $i['id']);
                array_push($listUpdate, $i);
            } else {
                array_push($listInsert, $i);
            }
            $validation = validator($i, [
                'product_name'          => 'required|max:100',
                'price'                 => 'required|max:19',
                'active'                => 'required|max:8',
            ]);
            if ($validation->fails()) {
                return ['code' => 'ERROR', 'messages' => 'Thiếu thông tin về sản phẩm', 'error' => $validation->errors()];
                break;
            }
        }
        /* dd($listUpdate, $listInsert, $listIdUpdate); */
        DB::beginTransaction();
        try {
            if (count($listInsert) > 0) {
                DB::table('menu')->insert($listInsert);
            }
            if (count($listUpdate) > 0) {
                DB::table('menu')
                    ->whereIn('id', $listIdUpdate)
                    ->delete();

                DB::table('menu')->insert($listUpdate);
            }
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'messages' => $e->errorInfo, 'error' => $e];
        }
        DB::commit();
        return ['code' => 'SUCCESS'];
    }

    public function deleteMenuItem()
    {
        $input = ('list');
        /* dd($input); */
        foreach ($input as $i) {
            $validation = validator($i, [
                'id'                => 'required|max:8',
            ]);
            if ($validation->fails()) {
                return ['code' => 'ERROR', 'messages' => 'Thiếu thông tin về sản phẩm', 'error' => $validation->errors()];
                break;
            }
        }
        try {
            DB::table('menu')
                ->whereIn('id', $input)
                ->update(['deleted_at' => now()]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'messages' => $e];
        }
        return ['code' => 'SUCCESS'];
    }
}
