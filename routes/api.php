<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('courier', 'MasterController@getCourier');
Route::get('outbound-status', 'MasterController@getOutboundStatus');
Route::get('inbound-status', 'MasterController@getInboundStatus');
Route::get('order-status', 'MasterController@getOrderStatus');
Route::get('platform', 'MasterController@getPlatform');
Route::get('space-type', 'MasterController@getSpaceType');
Route::get('user-role', 'MasterController@getUserRole');
Route::get('user-status', 'MasterController@getUserStatus');
Route::get('province', 'MasterController@getProvince');
Route::get('city', 'MasterController@getCity');

Route::get('platform/{id}', 'MasterController@getPlatformById');

Route::post('resend-verification', 'AuthController@resendVerification');
Route::get('check-verification/{token}', 'AuthController@checkVerification');

Route::post('forgot-password', 'AuthController@forgotPassword');
Route::post('change-password', 'AuthController@changePassword');

Route::group(['middleware' => ['auth.token']], function () {

    Route::get('/profile', 'AuthController@profile');

    Route::post('/topup', 'BalanceController@topUp');
    Route::post('/balance/{id}', 'BalanceController@update');
    Route::get('/datatable/topup-history', 'BalanceController@dataTable');

    Route::get('/addon', 'AddonController@index');
    Route::get('/addon/{id}', 'AddonController@show');
    Route::post('/addon', 'AddonController@store');
    Route::post('/addon/{id}', 'AddonController@update');
    Route::delete('/addon/{id}', 'AddonController@destroy');
    Route::get('/datatable/addon', 'AddonController@dataTable');

    Route::get('/cart', 'CartController@index');
    Route::get('/cart/{id}', 'CartController@show');
    Route::post('/cart', 'CartController@store');
    Route::post('/cart/{id}', 'CartController@update');
    Route::delete('/cart/{id}', 'CartController@destroy');
    // Route::get('/datatable/cart', 'CartController@dataTable');

    // Route::get('/error-log', 'ErrorLogController@index');
    // Route::get('/error-log/{id}', 'ErrorLogController@show');
    // Route::post('/error-log', 'ErrorLogController@store');
    // Route::post('/error-log/{id}', 'ErrorLogController@update');
    Route::get('/datatable/error-log', 'ErrorLogController@dataTable');

    Route::get('/inbound', 'InboundController@index');
    Route::get('/inbound/{id}', 'InboundController@show');
    Route::post('/inbound', 'InboundController@store');
    Route::post('/inbound/{id}', 'InboundController@update');
    Route::delete('/inbound/{id}', 'InboundController@destroy');
    Route::get('/datatable/inbound', 'InboundController@dataTable');

    Route::get('/integration', 'IntegrationController@index');
    Route::get('/integration/{id}', 'IntegrationController@show');
    Route::post('/integration', 'IntegrationController@store');
    Route::post('/integration/{id}', 'IntegrationController@update');
    Route::delete('/integration/{id}', 'IntegrationController@destroy');
    Route::get('/datatable/integration', 'IntegrationController@dataTable');

    Route::get('/inventory', 'InventoryController@index');
    Route::get('/inventory/{id}', 'InventoryController@show');
    Route::post('/inventory', 'InventoryController@store');
    Route::post('/inventory/{id}', 'InventoryController@update');
    Route::get('/datatable/inventory', 'InventoryController@dataTable');
    
    Route::get('/order', 'OrderController@index');
    Route::get('/order/{id}', 'OrderController@show');
    Route::post('/order', 'OrderController@store');
    Route::post('/order/{id}', 'OrderController@update');
    Route::delete('/order/{id}', 'OrderController@destroy');
    Route::get('/datatable/order', 'OrderController@dataTable');

    Route::get('/outbound', 'OutboundController@index');
    Route::get('/outbound/{id}', 'OutboundController@show');
    Route::post('/outbound', 'OutboundController@store');
    Route::post('/outbound/{id}', 'OutboundController@update');
    Route::delete('/outbound/{id}', 'OutboundController@destroy');
    Route::get('/datatable/outbound', 'OutboundController@dataTable');
    Route::post('/outbound/shipment/{id}', 'OutboundController@updateShipment');

    Route::get('/product', 'ProductController@index');
    Route::get('/product/{id}', 'ProductController@show');
    Route::post('/product', 'ProductController@store');
    Route::post('/product/{id}', 'ProductController@update');
    Route::delete('/product/{id}', 'ProductController@destroy');
    Route::get('/datatable/product', 'ProductController@dataTable');

    Route::get('/space', 'SpaceController@index');
    Route::get('/space/{id}', 'SpaceController@show');
    Route::post('/space', 'SpaceController@store');
    Route::post('/space/{id}', 'SpaceController@update');
    Route::delete('/space/{id}', 'SpaceController@destroy');
    Route::get('/datatable/space', 'SpaceController@dataTable');

    Route::get('/storage', 'StorageController@index');
    Route::get('/storage/{id}', 'StorageController@show');
    Route::post('/storage', 'StorageController@store');
    Route::post('/storage/{id}', 'StorageController@update');
    Route::delete('/storage/{id}', 'StorageController@destroy');
    Route::get('/datatable/storage', 'StorageController@dataTable');

    Route::get('/store', 'StoreController@index');
    Route::get('/store/{id}', 'StoreController@show');
    Route::post('/store', 'StoreController@store');
    Route::post('/store/{id}', 'StoreController@update');
    Route::delete('/store/{id}', 'StoreController@destroy');
    Route::get('/datatable/store', 'StoreController@dataTable');

    Route::get('/user', 'UserController@index');
    Route::get('/user/{id}', 'UserController@show');
    Route::post('/user', 'UserController@store');
    Route::post('/user/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');
    Route::get('/datatable/user', 'UserController@dataTable');

    Route::get('/user-log', 'UserLogController@index');
    Route::get('/user-log/{id}', 'UserLogController@show');
    Route::post('/user-log', 'UserLogController@store');
    Route::post('/user-log/{id}', 'UserLogController@update');
    Route::delete('/user-log/{id}', 'UserLogController@destroy');
    Route::get('/datatable/user-log', 'UserLogController@dataTable');

    Route::get('/warehouse', 'WarehouseController@index');
    Route::get('/warehouse/{id}', 'WarehouseController@show');
    Route::post('/warehouse', 'WarehouseController@store');
    Route::post('/warehouse/{id}', 'WarehouseController@update');
    Route::delete('/warehouse/{id}', 'WarehouseController@destroy');
    Route::get('/datatable/warehouse', 'WarehouseController@dataTable');

    Route::delete('/cart', 'CartController@truncate');
    Route::delete('/user-log', 'UserLogController@truncate');
    Route::delete('/error-log', 'ErrorLogController@truncate');

    Route::post('/integration/{slug}/oauth', 'AuthController@integrationAuth');

    Route::get('/integration/{slug}/sync', 'ProductController@sync');

    Route::get('/rajaongkir/rates/{outboundId}', 'RajaOngkirController@rates');
    Route::get('/rajaongkir/waybill/{awb}', 'RajaOngkirController@checkShipment');

});

Route::get('/integration/{slug}/callback', 'AuthController@integrationCallback');
