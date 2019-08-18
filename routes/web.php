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
Route::get('/', 'HomeController@index')->name('home');

Route::get('/category/{slug}','CategoryController@index')->name('category');

Route::get('/product/{slug}','ProductController@index')->name('product.detail');



Route::post('/search','ProductController@search')->name('search');
Route::get('/search','ProductController@search')->name('search');

Route::group(['middleware' => 'auth'], function (){

    Route::get('/cart','CartController@index')->name('cart');

    Route::get('/checkout','CheckoutController@index')->name('checkout');

    Route::get('/orders','OrderController@index')->name('orders');

    Route::get('/order-detail/{id}','OrderController@detail')->name('order.detail');
});


Route::group(['prefix' => 'user'], function (){

    Route::get('/login','KullaniciController@loginForm')->name('loginForm');

    Route::get('/register','KullaniciController@registerForm')->name('registerForm');

    Route::post('/login','KullaniciController@login')->name('user.login');

    Route::post('/logout','KullaniciController@logout')->name('user.logout');

    Route::post('/register','KullaniciController@register')->name('user.regist  er');

    Route::get('/activation/{activation_key}','KullaniciController@activation')->name('user.activation');

});

Route::get('/test/mail', function (){
    $user = App\User::find(3);
    return new App\Mail\UserRegistrationMail($user);

});
