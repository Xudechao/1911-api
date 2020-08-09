<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\TokenModel;
use App\Model\UserModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Redis;

class TestController extends Controller
{
    /**
     * 注册
     * @param Request $request
     */
    public function reg(Request $request)
    {
        $usernema = $request->post('username');
        $user_email = $request->post('email');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //验证用户名 email 密码

        $pass = password_hash($pass1,PASSWORD_BCRYPT);

        $user_info = [
            'username' => $usernema,
            'email' => $user_email,
            'password' => $pass,
            'reg_time' => time()

        ];

        $lid = UserModel::insertGetId($user_info);

        $response = [
            'erron' => 0,
            'msg' => 'OK'
        ];
        return $response;

    }

    /**
     * 登录
     * @param Request $request
     */
    public function login()
    {
        $username = \request()->input('username');
        $pass = \request()->input('pass');
//       dd($pass);die;
        //验证登录信息
        $user = UserModel::where(['username'=>$username])->first();

        if($user) {
            //验证密码

            if (password_verify($pass, $user->password)) {
                $response = [
                    'erron' => 0,
                    'msg' => 'OK'
                ];
            } else {
                $response = [
                    'erron' => 500001,
                    'msg' => '密码错误'
                ];
            }

            //生成token
            $token = Str::random(32);

            $expire_seconds = 300;
            $data = [
                'token' => $token,
                'lid' => $user->lid,
                //'expire_at' => time() + $expire_seconds
            ];
            //入库
            $tid = TokenModel::insertGetId($data);
            $response = [
                'erron' => 0,
                'msg' => 'OK',
                'data' => [
                    'token' => $token,
                    'expire_in' => $expire_seconds
                ]
            ];
        }else{
            $response = [
                'erron' => 400001,
                'msg' => '用户不存在'
            ];
        }
        return $response;

    }

    /**
     *商品
     */
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
