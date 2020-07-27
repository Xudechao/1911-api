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

Route::get('/test/dec','TestController@dec');
Route::post('/test/dersa','TestController@dersa');
Route::get('/test/sign1','TestController@sign1');
Route::get('/test1','TestController@test1');

#**********************************************************
Route::get('/test/hash1','TestController@hash1');
Route::get('/test/hash2','TestController@hash2')->middleware('cont');
#***********************************************************
Route::post('/user/reg','User\IndexController@reg');     //注册
Route::post('/user/login','User\IndexController@login');      //登录
//Route::get('/user/center','User\IndexController@center');      //个人中心
Route::get('/user/center','User\IndexController@center')->middleware('verfiy.token','count'); //个人中心
Route::post('/user/logins','User\IndexController@logins')->middleware('token','user');      //登录
#************************************************************
Route::get("/has","TestController@has");
Route::get("/gethas","TestController@gethas");
#*************************************************************
Route::get('/goods','TestController@goods');    //商品 访问 次数
//Route::get('/test1','TestController@test1')->middleware('count');    //访问次数2
Route::get('/token2','TestController@token2');
#*************************************************************
Route::get('/a/test1','TestController@test1');
Route::get('/a/test2','TestController@test2');
#*************************************************************
