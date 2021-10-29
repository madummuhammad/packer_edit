<?php

use Illuminate\Support\Facades\Route;

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

Route::view('/', 'pages.frontend.index');
Route::view('/kenapa-packer', 'pages.frontend.why_packer');
Route::view('/cara-kerja', 'pages.frontend.how_it_works');
Route::view('/layanan', 'pages.frontend.services');
Route::view('/mitra-gudang', 'pages.frontend.packer_partner');
Route::post('/kirimemail', 'MitraMailController@index');
Route::view('/price-list', 'pages.frontend.pricing_list');

Route::view('/resend-verification', 'auth.resend_verification');
Route::view('/forgot-password', 'auth.forgot_password');
Route::view('/change-password/{token}', 'auth.change_password');

Route::view('/login', 'auth.login')->name('login');

Route::post('/sign-up', 'AuthController@signUp');
Route::post('/sign-in', 'AuthController@signIn');
Route::get('/sign-out', 'AuthController@signOut');

Route::middleware('auth')->group(function () {

    // Integration
    Route::view('/integration/{slug}', 'auth.integration_')->name('integration');

    Route::prefix('admin')->group(function () {

        Route::view('/user/profile', 'pages.backend.profile');
        Route::view('/user/topup-history', 'pages.backend.topup_history');

        Route::prefix('main')->group(function () {

            Route::view('/dashboard', 'pages.backend.dashboard');
            Route::view('/store', 'pages.backend.store');
            Route::view('/product', 'pages.backend.product');
            Route::view('/book-spaces', 'pages.backend.book_space');
            Route::view('/invoice', 'pages.backend.invoice');
            Route::view('/invoice/{id}', 'pages.backend.invoice_detail');
            Route::view('/storage', 'pages.backend.storage');
            Route::view('/inbound', 'pages.backend.inbound');
            Route::view('/outbound', 'pages.backend.outbound');
            Route::view('/inventory', 'pages.backend.inventory');
            Route::view('/integration', 'pages.backend.integration');
            Route::view('/report', 'pages.backend.report');

            Route::view('/shipment-label/{outboundId}', 'pages.backend.shipment_label');

            Route::view('/outbound/chat', 'pages.backend.outbound_chat');
        });

        Route::prefix('master-data')->group(function () {

            Route::view('/warehouse', 'pages.backend.master_data.warehouse');
            Route::view('/space', 'pages.backend.master_data.space');
            Route::view('/addon', 'pages.backend.master_data.addon');
        });

        Route::prefix('settings')->group(function () {

            Route::view('/user-management', 'pages.backend.settings.user_management');
            Route::view('/user-log', 'pages.backend.settings.user_log');
            Route::view('/error-log', 'pages.backend.settings.error_log');
        });
    });
});
