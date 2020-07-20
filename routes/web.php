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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/info', function () {
   phpinfo();
});

Route::get('/test/hash1','TestController@hash1');
Route::get('/test/hash2','TestController@hash2');

Route::post('/user/reg','User\IndexController@reg');     //注册
Route::post('/user/login','User\IndexController@login');      //登录
Route::get('/user/center','User\IndexController@center');      //个人中心

Route::get("/has","TestController@has");
Route::get("/gethas","TestController@gethas");

Route::get('/goods','TestController@goods');

Route::get('test1','TestController@test1');
Route::get('test2','TestController@test2');

