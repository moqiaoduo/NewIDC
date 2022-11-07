<table style="width: 100%">
    <tbody>
    <tr>
        <td>{{$product->group->name}} - {{$product->name}}</td>
        <td width="100" align="right">￥{{$base}}</td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    @if($price['period_unit']!='unlimited')
    <tr>
        <td colspan="2">下次付款总计</td>
    </tr>
    <tr>
        <td>@lang('price.'.$price['name'])</td>
        <td width="100" align="right">￥{{sprintf("%.2f", $price['price'])}}</td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    @endif
    <tr>
        <td>初装费</td>
        <td width="100" align="right">￥{{sprintf("%.2f", $price['setup'])}}</td>
    </tr>
    <tr>
        <td colspan="2"><hr></td>
    </tr>
    <tr>
        <td colspan="2">当前总计<h1 style="font-weight: 400;font-size: 34px;margin: 10px 0 20px;">￥{{$total}}</h1></td>
    </tr>
    <tr>
        <td colspan="2">
            <button lay-submit class="layui-btn layui-btn-fluid">
                @if ($login)
                    下单
                @else
                    登录后才能下单
                @endif
            </button>
        </td>
    </tr>
    </tbody>
</table>
