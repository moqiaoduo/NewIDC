<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title') - {{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('vendor/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    @yield('head')
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">{{config('app.name')}}</div>
        <div class="layui-layout-left">
            <span class="newidc-nav-show-button">
                <i class="layui-icon">&#xe668;</i>
            </span>
        </div>
        <ul class="layui-nav layui-layout-right">
            @include('common.head_avatar')
        </ul>
    </div>
    <div class="layui-side layui-bg-black" id="newidc-nav">
        <ul class="layui-nav layui-nav-tree">
            <li class="layui-nav-item"><a href="{{url('/')}}">首页</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">默认展开</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">选项1</a></dd>
                    <dd><a href="javascript:;">选项2</a></dd>
                    <dd><a href="">跳转</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="">产品</a></li>
            <li class="layui-nav-item"><a href="">大数据</a></li>
        </ul>
    </div>
    <div class="layui-body" id="newidc-body">
        <div class="layui-container">
            @yield('content')
        </div>
    </div>
    <div class="layui-footer newidc-footer">
        @include('common.foot')
    </div>
    <script src="{{asset('vendor/layui/layui.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
    @yield('foot')
</div>
</body>
</html>
