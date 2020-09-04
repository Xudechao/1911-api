<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->input('goods_name');
        $where = [];
        if($where){
            $where[] = ["goods_name","like","%$name%"];
        }
        $goods = GoodsModel::where($where)->orderBy("goods_id","desc")->limit(50)->paginate(5);

        return view("goods.goods",["goods"=>$goods]);

    }
}
