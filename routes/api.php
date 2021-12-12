<?php

use Illuminate\Http\Request;
// use Illuminate\Routing\Route;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', 'Api\UserController@Login');
Route::post('register', 'Api\UserController@register');
Route::post('checkout', 'Api\TransaksiController@store');
Route::get('produk', 'Api\ProdukController@index');
Route::get('produk/kategori/{kategori_id}', 'Api\ProdukController@get_id');
Route::get('produk/kategori_nolimit/{kategori_id}', 'Api\ProdukController@get_id_all');
Route::get('checkout/user/{id}', 'Api\TransaksiController@history');
Route::post('checkout/batal/{id}', 'Api\TransaksiController@batal');
Route::post('checkout/upload/{id}', 'Api\TransaksiController@upload');
Route::post('push', 'Api\TransaksiController@pushNotif');
Route::get('user/{id}', 'Api\UserController@index');