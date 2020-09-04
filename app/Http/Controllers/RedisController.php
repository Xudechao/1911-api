<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Model\LoginModel;
class RedisController extends Controller
{
    public function e(){
        $add = LoginModel::get();
        if($add){
            echo json_encode(['code'=>'000000',',msg'=>'ok','data'=>$add->toArray()]);
        }
    }
    public function d()
    {
       $data = \request()->all();
//       print_r($data);exit;
        $post = [
            "username"=>$data['username'],
            "mobile"=>$data['mobile'],
            "addtime"=>time()
        ];
        $add = LoginModel::insert($post);
    }
    public function c()
    {
        $key1 = "xuluhao";
        $key2 = "liujiajie";

        $res = Redis::sunion($key1,$key2);
        print_r($res);
    }
    public function b()
    {
        $key1 = "xuluhao";
        $key2 = "liujiajie";

        $res = Redis::sdiff($key1,$key2);
        print_r($res);
    }
    public function a()
    {
        $key1 = "xuluhao";
        $key2 = "liujiajie";

        Redis::sadd($key1,"xcg","wyl","wjs","whh","lyz","sfx");
        Redis::sadd($key2,"jk","wan","wsx","whh","lyz","sfx");
        $res = Redis::sinter($key1,$key2);
        print_r($res);
    }
}
