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

Route::group(['prefix' => 'cart'], function (){
    Route::get('/','CartController@index')->name('cart');
    Route::post('/add','CartController@addToCart')->name('add.cart');
    Route::delete('/remove/{rowId}','CartController@destroy')->name('remove.cart');
    Route::delete('/truncate','CartController@truncateCart')->name('truncate.cart');
    Route::patch('/update/{id}','CartController@update')->name('update.cart');
});

Route::get('/checkout','CheckoutController@index')->name('checkout');
Route::post('/payment','CheckoutController@payment')->name('payment');

Route::group(['middleware' => 'auth'], function (){

    Route::get('/orders','OrderController@index')->name('orders');

    Route::get('/order-detail/{id}','OrderController@detail')->name('order.detail');
});


Route::group(['prefix' => 'user'], function (){

    Route::get('/login','KullaniciController@loginForm')->name('loginForm');

    Route::get('/register','KullaniciController@registerForm')->name('registerForm');

    Route::post('/login','KullaniciController@login')->name('user.login');

    Route::post('/logout','KullaniciController@logout')->name('user.logout');

    Route::post('/register','KullaniciController@register')->name('user.register');

    Route::get('/activation/{activation_key}','KullaniciController@activation')->name('user.activation');

});

Route::group(['prefix' => 'admin','namespace' => 'Admin'],function (){

    Route::group(['middleware' => 'admin'], function (){

        Route::get('/','DashboardController@index')->name('dashboard');

    });

   /* Route::get('/login','KullaniciController@adminLogin')->name('admin.loginPage');
    Route::post('/admin-login','KullaniciController@login')->name('admin.login');*/

    Route::match(['get','post'],'/login','KullaniciController@login')->name('admin.login');

    Route::post('logout','KullaniciController@logout')->name('admin.logout');
});
/*
Route::get('/test/mail', function (){
    $user = App\User::find(3);
    return new App\Mail\UserRegistrationMail($user);

});*/
