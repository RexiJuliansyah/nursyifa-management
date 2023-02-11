<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\TransactionController;

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



Auth::routes();
Route::get('/', function () {
    return view('auth/login');
});


Route::group(['middleware' => 'revalidate'], function(){

    Route::get('home', [HomeController::class, 'index'])->name('home');

    Route::get('menu', [MenuController::class, 'index'])->name('menu');
    Route::get('menu-datatable', [MenuController::class, 'datatable'])->name('menu.datatable');
    Route::post('menu-store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('menu-menuSelect2', [MenuController::class, 'menuSelect2'])->name('menu.menuSelect2');
    Route::get('menu-getbykey', [MenuController::class, 'getbykey'])->name('menu.getbykey');
    Route::delete('menu-delete', [MenuController::class, 'delete'])->name('menu.delete');
    Route::post('menu-getmenutree', [MenuController::class, 'getMenu'])->name('menu.getmenutree');
    Route::get('menu-export', [MenuController::class, 'export'])->name('menu.export');

    Route::get('system', [SystemController::class, 'index'])->name('system');
    Route::get('system-datatable', [SystemController::class, 'datatable'])->name('system.datatable');
    Route::post('system-store', [SystemController::class, 'store'])->name('system.store');
    Route::get('system-getbykey', [SystemController::class, 'getbykey'])->name('system.getbykey');
    Route::delete('system-delete', [SystemController::class, 'delete'])->name('system.delete');

    Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::get('role-datatable', [RoleController::class, 'datatable'])->name('role.datatable');
    Route::post('role-store', [RoleController::class, 'store'])->name('role.store');
    Route::get('role-getbykey', [RoleController::class, 'getbykey'])->name('role.getbykey');
    Route::delete('role-delete', [RoleController::class, 'delete'])->name('role.delete');
    Route::get('role-getpermission', [RoleController::class, 'getPermission'])->name('role.getpermission');
    Route::post('role-storepermission', [RoleController::class, 'storePermission'])->name('role.storepermission');

    Route::get('user', [UserController::class, 'index'])->name('user');
    Route::get('user-datatable', [UserController::class, 'datatable'])->name('user.datatable');
    Route::get('user-getbykey', [UserController::class, 'getbykey'])->name('user.getbykey');
    Route::post('user-store', [UserController::class, 'store'])->name('user.store');
    Route::delete('user-delete', [UserController::class, 'delete'])->name('user.delete');

    Route::get('transport', [TransportController::class, 'index'])->name('transport');
    Route::get('transport-datatable', [TransportController::class, 'datatable'])->name('transport.datatable');
    Route::get('transport-getbykey', [TransportController::class, 'getbykey'])->name('transport.getbykey');
    Route::post('transport-store', [TransportController::class, 'store'])->name('transport.store');
    Route::delete('transport-delete}', [TransportController::class, 'delete'])->name('transport.delete');

    Route::get('transaksi', [TransactionController::class, 'index'])->name('transaksi');
    Route::get('transaksi-baru', [TransactionController::class, 'add_transaction'])->name('transaksi.baru');
    Route::post('transaksi-store', [TransactionController::class, 'store_transaction'])->name('transaksi.store');

});
