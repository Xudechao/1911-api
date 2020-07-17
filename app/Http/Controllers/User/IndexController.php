<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\UserModel;
use App\Model\TokenModel;
use Illuminate\Support\Str;

class IndexController extends Controller
{
    /**
     * 注册
     * @param Request $request
     */
    public function reg(Request $request)
    {
        $user_nema = $request->post('user_name');
        $user_email = $request->post('email');
        $pass1 = $request->post('pass1');
        $pass2 = $request->post('pass2');

        //验证用户名 email 密码

        $pass = password_hash($pass1,PASSWORD_BCRYPT);

        $user_info = [
            'user_name' => $user_nema,
            'email' => $user_email,
            'password' => $pass,
            'reg_time' => time()

        ];

        $uid = UserModel::insertGetId($user_info);

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
        $user_name = \request()->input('user_name');
        $pass = \request()->input('pass');
//       dd($pass);die;
        //验证登录信息
        $user = UserModel::where(['user_name'=>$user_name])->first();

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

            $expire_seconds = 7200;
            $data = [
                'token' => $token,
                'uid' => $user->user_id,
                'expire_at' => time() + $expire_seconds
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
     * 个人中心❤
     */
    public function center(Request $request)
    {
        //验证是否有token
        $token = $request->get('token');
        if(empty($token))
        {

            $response = [
                'erron' => 400003,
                'msg' => '未授权'
            ];
            return$response;
        }

//        验证token是否有效
        $t = TokenModel::where(['token'=>$token])->first();
        //未找到token
        if(empty($t)){
            $response = [
                'erron' => 400002,
                'msg' => 'token无效'
            ];
            return$response;
        }

        $user_info = UserModel::find($t->uid);
//        var_dump($user_info);
        $response = [
            'erron' => 0,
            'msg' => 'ok',
            'data' => [
                'user_info' => $user_info
            ]
        ];
//
        return $response;

    }

}
