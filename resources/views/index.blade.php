@extends('layout')

@section('title', '首页')

@section('head')
@endsection

@section('foot')
@endsection

@section('content')
    <div class="layui-row">
        <h1 style="text-align: center;">欢迎来到 {{config('app.name')}}</h1>
    </div>
    <div class="layui-row">
        <h2 style="text-align: center;">为您推荐以下产品</h2>
    </div>
    <div class="layui-row layui-col-space20 newidc-margin-top20">
        <div class="layui-col-md3">
            <div class="newidc-index-product">
                <ul>
                    <li>
                        <div>产品名</div>
                        <div>价格</div>
                    </li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>属性</li>
                    <li>
                        <a class="layui-btn layui-btn-fluid" href="">立即购买</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
