<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class SettingsController extends Controller
{
    private $settings = array();

    public function index()
    {
        return view('settings_page.index', [
            'title' => 'Settings Page',
        ]);
    }

    public function loadSettings()
    {
        $where = '<>';
        $id = '';
        if(!empty(request('id'))){
            $where = '=';
            $id = request('id');
        }
        $setting = DB::table('setting')
        ->where('id',$where,$id)
        ->get();
        $configPage = array();
        foreach ($setting as $row) {
            $row = (array)$row;
            $configPage[$row['key_word']] = [
                'id' => $row['id'],
                'value' => $row['value'],
                'type' => $row['type'],
                'title' => $row['title'],
                'key_word' => $row['key_word']
            ];
        }
        return $configPage;
    }

    public function saveSettings()
    {
        $request = request()->all();
        foreach ($request as $key => $row) {
            try {
                DB::table('setting')
                    ->where('id', $row['id'])
                    ->where('key_word', $row['key_word'])
                    ->update(['value' => $row['value']]);
            } catch (\Exception $e) {
                return ['code' => 'success','message' => $e->errorInfo];
            }
        }

        return ['code' => 'success','message' => 'Đã lưu'];
    }
}
