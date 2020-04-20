@extends('layout')

@section('title', __('Buy'))

@section('head')
    <style>
        .layui-body {
            background: #f6f7f8;
        }
    </style>
@endsection

@section('foot')
    <script>
        layui.use(['form', 'jquery', 'layer'], function () {
            var form = layui.form,
                $ = layui.jquery,
                layer = layui.layer;

            form.on('radio(period)', function (data) {
                loadCalc(data.value)
            })

            $(document).ready(function () {
                loadCalc($('#selected-period').val())
            })

            function loadCalc(id) {
                $("#calc-loading").show()
                $("#buy-calc").load("/api/buy/{{$product->id}}/calc/" + id +
                    '?lang={{App::getLocale()}}&login={{$guest?0:1}}', function () {
                    $("#calc-loading").hide()
                })
            }

            @error('tip')
            layer.alert('{{$message}}', {icon: 0})
            @enderror
        })
    </script>
@endsection

@section('content')
    <form class="layui-form layui-row layui-col-space20" method="post" action="{{route('buy',$product)}}">
        @csrf
        <div class="layui-col-md8">
            <div class="layui-card">
                <div class="layui-card-header"><h2>{{$product->group->name}} - {{$product->name}}</h2></div>
                <div class="layui-card-body">
                    {!! $product->getCleanDescription() !!}
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header"><h2>付款周期</h2></div>
                <div class="layui-card-body">
                    @foreach($product->price as $id=>$price)
                        @if(!$price['enable'])
                            @continue
                        @endif
                        @if($price['period_unit']=='unlimited' && $product->price_configs['unlimited_when_buy'])
                            @continue
                        @endif
                        <input type="radio" name="period" value="{{$id}}" lay-filter="period"
                               title="@lang('price.'.$price['name'])<br>
{{($price['price'] > 0 ? ('￥'.sprintf("%.2f",$price['price']) ) : '免费') .
($price['setup'] > 0 ? '<br>设置费￥'.sprintf("%.2f",$price['setup']) : '')}}"
                               @if(($period = $options['period']??null)==$id || !$period && $loop->first)
                               checked id="selected-period"
                            @endif>
                    @endforeach
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header"><h2>优惠码</h2></div>
                <div class="layui-card-body">
                    <input type="text" name="promotion_code" class="layui-input"
                           style="width: calc(100% - 110px); display: inline-block;">
                    <button type="button" class="layui-btn">验证并使用</button>
                </div>
            </div>
            <div class="layui-card">
                <div class="layui-card-header"><h2>附加信息</h2></div>
                <div class="layui-card-body">
                    @if($product->require_domain)
                        <div class="layui-form-item">
                            <label class="layui-form-label">域名</label>
                            <div class="layui-input-block">
                                <input type="text" name="extra[domain]" required lay-verify="required"
                                       autocomplete="off" class="layui-input">
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="layui-col-md4">
            <div class="layui-card">
                <div class="layui-card-header">
                    <h2>计费 <i class="layui-icon layui-icon-loading-1 layui-icon layui-anim
                    layui-anim-rotate layui-anim-loop" id="calc-loading" style="display: none;"></i></h2>
                </div>
                <div class="layui-card-body" id="buy-calc">
                    <button lay-submit class="layui-btn layui-btn-fluid">下单</button>
                </div>
            </div>
        </div>
    </form>
@endsection
