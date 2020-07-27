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

    public function test1()
    {
        echo __METHOD__;
    }

    public function token2()
    {
        $id = Request()->get("id");
        $key = "token";
        $count = Redis::incr(1);
        Redis::zadd($key, $id, $count);
        $counts = Redis::zcard($key);
        echo $counts;
    }

    /**
     * 解密
     * @param Request $request
     */
    public function dec(Request $request)
    {
        $mehod = 'AES-256-CBC';
        $keye = '1911www';
        $lv = '1233211233211231';
        $option = OPENSSL_RAW_DATA;

        $enc = base64_decode($request->post('data'));
        $dec = openssl_decrypt($enc,$mehod,$keye,$option,$lv);
        echo "解密数据：".$dec;
    }

    public function dersa(){
        $enc_data = $_POST["data"];
        $blog_pub_key = file_get_contents(storage_path("keys/www_pub.key"));
        openssl_public_decrypt($enc_data,$dec_data,$blog_pub_key);
        ######################################################################
        $data = "已收到";
        $content = openssl_get_privatekey(file_get_contents(storage_path("keys/api_priv.key")));
        $priv_key = openssl_get_privatekey($content);
        openssl_private_encrypt($data,$enc_data,$priv_key);
        echo $enc_data;
    }

    public function sign1(Request $request)
    {
        $key = '1911www';

        // echo '<pre>';print_r($_GET);echo '</pre>';

        //接收数据
        $data = $request->get('data');
        $sign = $request->get('sign');

        //计算签名
        $sing_s2 = md5($data . $key);
        if($sing_s2 == $sign)
        {
            echo "验签成功";
        }else{
            echo "验签失败";
        }

    }

}
