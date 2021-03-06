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

Route::any("/a","RedisController@a");
Route::any("/b","RedisController@b");
Route::any("/c","RedisController@c");
Route::post("/d","RedisController@d");
Route::post("/e","RedisController@e");

#**********************************************************
Route::any("index/goods","Index\RedisController@index"); //列表展示
#**********************************************************
Route::post('/reg/reg','Index\TestController@reg'); //注册
Route::post('/reg/login','Index\TestController@login'); //登录
Route::post('/reg/goods','Index\TestController@goods'); //商品
#************************************************************
Route::any("/user/login","Index\LoginController@login");
Route::any("/user/reg","Index\LoginController@reg");
//Route::get("/user/goshop/{goods_id}","Index\CarController@goshop");
#*************************************************** ******
Route::get('/test/dec','TestController@dec');
Route::post('/test/dersa','TestController@dersa');
Route::get('/test/sign1','TestController@sign1');
Route::get('/test1','TestController@test1');
#**********************************************************
Route::get('/test/hash1','TestController@hash1');
Route::get('/test/hash2','TestController@hash2')->middleware('cont');
#***********************************************************
//Route::post('/user/reg','Index\LoginController@reg');
//Route::post('/user/login','Index\LoginController@login');
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
