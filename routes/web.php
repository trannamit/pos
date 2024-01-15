<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\Auth\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [LoginController::class, 'index'])->name('login');;
Route::post('/login', [LoginController::class, 'login']);
Route::get('/', [HomeController::class, 'infor']);
Route::post('/menu_list_client', [TableController::class, 'getMenuList']);

Route::group(['middleware' => 'auth'], function () {
    // homePage
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/test', [HomeController::class, 'test']);

    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/new-table', [HomeController::class, 'createNewTable']);
    //---------data
    Route::post('/table_list', [HomeController::class, 'getTableList']);
    Route::post('/statistics', [HomeController::class, 'getStatistics']);

    // Table
    Route::get('/table-{id}', [TableController::class, 'showTable']);
    //---------data
    Route::post('/menu_list', [TableController::class, 'getMenuList']);
    Route::post('/table_infor', [TableController::class, 'getTableInfor']);
    Route::post('/save_update_item', [TableController::class, 'saveUpdateTable']);
    Route::post('/delete_items', [TableController::class, 'deleteItems']);
    Route::post('/delete_table', [TableController::class, 'deleteTable']);
    Route::post('/pay_items', [TableController::class, 'payItems']);

    // Menu
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    //---------data
    Route::post('/all_menu', [MenuController::class, 'getAllMenu']);
    Route::post('/save_update_menu', [MenuController::class, 'saveUpdateMenu']);
    Route::post('/delete_menu_items', [MenuController::class, 'deleteMenuItem']);


    // bill
    Route::get('/list-bill', [BillController::class, 'index'])->name('bill');
    Route::get('/bill-{id}', [BillController::class, 'showBill']);
    //---------data
    Route::post('/get_data_bills', [BillController::class, 'getDataBills']);

    // profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    //---------data
    Route::post('/update_name', [ProfileController::class, 'updateName']);
    Route::post('/change_password', [ProfileController::class, 'changePassword']);

    // Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    //---------data
    Route::post('/get_settings', [SettingsController::class, 'loadSettings']);
    Route::post('/post_settings', [SettingsController::class, 'saveSettings']);
});
