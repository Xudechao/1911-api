<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use DB;
use App\Model\GoodsModel;

class TestController extends Controller
{
    public function hash1()
    {
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

    public function has()
    {
        $shop = "shop";
        $str = "1";
        Redis::lpush($shop,$str);

    }

    public function gethas()
    {
        $shop = "shop";
        $key = Redis::lrange($shop, 1, -1);
        $key = Redis::llen($shop);
        if ($key) {
            echo "商品还有".$key."件";
            Redis::lpop($shop);
        }
        if(empty($key)){
            echo "商品已卖完";exit;
        }
    }

    public function goods(Request $request)
    {
        $goods_id = $request->get('id');
        $key1 = 'count:view:goods:'.$goods_id;
        echo Redis::incr($key1); echo '</br>';

        $key = 'h:goods_info:'.$goods_id;
        //先判断缓存
        $goods_info = Redis::hgetAll($key);

        if(empty($goods_info))
        {
            $goods = GoodsModel::select('goods_id','goods_sn','cat_id','goods_name')->find($goods_id);
            //缓存到redis中去
            $goods_info = $goods->toArray();
            Redis::hMset($key,$goods_info);
            echo "未缓存";
            echo '<pre>';print_r($goods_info);echo '</pre>';die;
        }else{
            echo "缓存";
            echo '<pre>';print_r($goods_info);echo '</pre>';die;
        }
    }

}
