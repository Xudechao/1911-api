<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\GoodsModel;

class IndexController extends Controller
{
    /**
     * 首页查数据
     */
    public function cha(){
        $g= GoodsModel::all();
        print_r($g);die;
    }
}
