<form action="{{url(('index/goods'))}}" method="post">
    请输入名称：<input type="text" placeholder="请输入商品名称" name="goods_name"> <input type="submit" value="搜索">
</form>

<table border="11">
    <tr>
        <td>商品id</td>
        <td>商品名称</td>
        <td>商品库存</td>
        <td>商品价格</td>
    </tr>
    @foreach($goods as $v)
    <tr>
        <td>{{$v->goods_id}}</td>
        <td>{{$v->goods_name}}</td>
        <td>{{$v->goods_number}}</td>
        <td>{{$v->shop_price}}</td>
    </tr>
    @endforeach
</table>
{{ $goods->links() }}
