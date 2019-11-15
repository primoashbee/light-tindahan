<?php

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

use App\Cart;
use App\Events\MyEvent;
use App\Events\AddedToCart;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::get('/event',function(){
        $cart = Cart::first();
        event(new MyEvent('ashbee'));
        return 'fired';
    });
    Route::get('/api/items','ItemController@apiFetch');
    Route::get('/api/cart','CartController@apiFetch');
    Route::post('/api/cart/add','CartController@apiAddToCart');
    Route::post('/api/cart/update','CartController@apiUpdateCart');

    Route::get('/home', 'HomeController@index')->name('home');
        
});
