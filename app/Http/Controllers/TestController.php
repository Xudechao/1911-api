<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use DB;

class TestController extends Controller
{
    public function hash1()
    {
//        phpinfo();die;

        $data = [
            'name' => 'zhangsan',
            'email' => 'zhangsan@qq.com',
            'age' => 22
        ];

        $key = 'user_info1';
        Redis::hmset($key,$data);
    }

    public function hash2()
    {
        $key = 'user_info1';
        $redis = Redis::hgetall($key);
        print_r($redis);
    }

}
