<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function index()
    {
        return view('home.index', [
            'title' => 'Home',
        ]);
    }

    public function infor()
    {
        $setting = DB::table('setting')->get();
        $configPage = array();
        foreach ($setting as $row) {
            $row = (array) $row;
            $configPage[$row['key_word']] = [
                'value' => $row['value'],
                'type' => $row['type'],
                'title' => $row['title'],
            ];
        }
        $extends = 'mainClien';
        $section = 'contentClien';
        if (!empty(auth()->user())) {
            $section = 'content';
            $extends = 'main';
        }
        return view('infor.index', [
            'title' => $configPage['name_shop']['value'],
            'data' => $configPage,
            'section' => $section,
            'extends' => $extends
        ]);
    }

    public function getTableList()
    {
        $item = DB::select('SELECT t.id, t.created_at, table_number, t.name_table, COUNT(p.id) AS total
            FROM table_item t LEFT JOIN product_in_table p ON t.id = p.table_id
            WHERE p.cashier_id IS NULL and t.deleted_at IS NULL
            GROUP BY t.table_number, t.name_table
            ORDER BY t.id ;
        ');

        return $item;
    }

    public function getStatistics()
    {
        $arrId = request('arrId');
        return DB::table('product_in_table as p')
            ->leftJoin('menu as m', 'p.product_id', 'm.id')
            ->rightJoin('table_item as t', 'p.table_id', 't.id')
            ->whereIn('t.id', $arrId)
            ->select('t.id as table_id', 'p.cashier_id', 'm.price')
            ->orderBy('table_id')
            ->get();
    }

    public function createNewTable()
    {
        $listTableNumberUsed = request('listTableNumber');
        $number = 1;
        if (isset($listTableNumberUsed)) {
            sort($listTableNumberUsed);
            $iEnd = sizeof($listTableNumberUsed);

            for ($i = 0; $i < $iEnd; $i++) {
                if ($listTableNumberUsed[$i] == $i + 1) {
                    $number++;
                } else {
                    break;
                }
            }
        }

        /* dd($listTableNumberUsed); */


        $id = -1;
        try {
            $id = DB::table('table_item')
                ->insertGetId([
                    'name_table' => 'Bàn khách số ' . $number,
                    'table_number' => $number,
                    'created_at' => now(),
                    'creater_id' => auth()->user()->user_id,
                ]);
        } catch (\Exception $e) {
            return ['code' => 'ERROR', 'message' => $e->errorInfo];
        }
        return ['code' => 'SUCCESS', 'id' => $id];
    }

    private $firebaseUrl = "https://notifi-94695-default-rtdb.asia-southeast1.firebasedatabase.app/";
    private $apiKey = "AIzaSyAE95Ik9u0EnAO6v8_xLl1Ms8jchgewrmI";

    private $token = 'akjhthrbkd';

    // Thêm dữ liệu
    private function addData($path, $data)
    {
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl . $path . '.json');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:key=' . $this->apiKey));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // Cập nhật dữ liệu
    private function updateData($path, $data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl . $path . '.json');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:key=' . $this->apiKey));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    // Xoá dữ liệu
    private function removeData($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->firebaseUrl . $path . '.json');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:key=' . $this->apiKey));
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function test(){
        $path = '/table/';
        //$result = $this->removeData($path . 5);
        //$result = $this->updateData($path . 3, array('id' => 3,'status' => 'off'));
        $result = $this->addData($path , array('id' => 5,'status' => 'on'));
        dd($result);

    }

}