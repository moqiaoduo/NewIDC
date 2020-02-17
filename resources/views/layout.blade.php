<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title') - {{config('app.name')}}</title>
    <link rel="stylesheet" href="{{asset('vendor/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <style>
        .newidc-index {
            left: 0 !important;
        }
    </style>
    @yield('head')
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">{{config('app.name')}}</div>
        <ul class="layui-layout-left">

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
        Copyright © {{now()->year}} {{config('app.name')}}. All rights reserved. |
        Powered by <a href="https://github.com/moqiaoduo/NewIDC" target="_blank">NewIDC</a>
    </div>
    <script src="{{asset('vendor/layui/layui.js')}}"></script>
    <script src="{{mix('js/app.js')}}"></script>
    @yield('foot')
</div>
</body>
</html>
