<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('vendor/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <link rel="stylesheet" href="{{mix('css/index.css')}}">
    @yield('head')
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">{{config('app.name')}}</div>
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="{{url('/')}}">@lang('Home')</a></li>
            <li class="layui-nav-item"><a href="{{route('shop')}}">@lang('Store')</a></li>
            @include('common.avatar', ['class' => 'newidc-little-head-avatar', 'avatar' => '客户'])
        </ul>
        <ul class="layui-nav layui-layout-right">
            @include('common.head_avatar')
        </ul>
    </div>
    <div class="layui-body newidc-index">
        <div class="layui-container">
            @yield('content')
        </div>
    </div>
    <div class="layui-footer newidc-footer newidc-index">
        @include('common.foot')
    </div>
    <script src="{{asset('vendor/layui/layui.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
    @yield('foot')
</div>
</body>
</html>
