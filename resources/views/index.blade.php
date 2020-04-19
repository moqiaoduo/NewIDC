@extends('layout')

@section('title', '首页')

@section('head')
@endsection

@section('foot')
@endsection

@section('content')
    <div class="layui-row">
        <h1 style="text-align: center;">@lang('Welcome to :site',['site'=>config('app.name')])</h1>
    </div>
    <div class="layui-row">
        <h2 style="text-align: center;">@lang('Recommend Products for you')</h2>
    </div>
    <div class="layui-row layui-col-space20 newidc-margin-top20">
        @foreach(\App\Models\Product::whereIn('id',
(array) json_decode(getOption('template_default_home_product'),true))->get() as $product)
        <div class="layui-col-md3">
            <div class="newidc-index-product">
                <ul>
                    <li>
                        <div>{{$product['name']}}</div>
                        <div>￥{{$product['price'][0]['price']??'Free'}} Start</div>
                    </li>
                    @foreach(explode("<br>",$product->getCleanDescription()) as $text)
                        @if(!empty(trim($text))) <li>{!! $text !!}</li> @endif
                    @endforeach
                    <li>
                        <a class="layui-btn layui-btn-fluid" href="{{route('buy',$product)}}">@lang('Buy NOW')</a>
                    </li>
                </ul>
            </div>
        </div>
        @endforeach
    </div>
@endsection
