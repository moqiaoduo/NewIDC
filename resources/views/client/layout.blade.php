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
            <li class="layui-nav-item"><a href="{{route('client')}}">@lang('Overview')</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">@lang('Services')</a>
                <dl class="layui-nav-child">
                    <dd><a href="{{route('services')}}">@lang('My Services')</a></dd>
                    <dd><a href="{{route('shop')}}">@lang('Store')</a></dd>
                    <dd><a href="javascript:;">@lang('Product Addon')</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">@lang('Billing')</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">@lang('My Invoices')</a></dd>
                    <dd><a href="javascript:;">@lang('Add Funds')</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item">
                <a href="javascript:;">@lang('Support')</a>
                <dl class="layui-nav-child">
                    <dd><a href="javascript:;">@lang('user.ticket')</a></dd>
                    <dd><a href="javascript:;">@lang('Announcements')</a></dd>
                    <dd><a href="javascript:;">@lang('user.open_ticket')</a></dd>
                </dl>
            </li>
            <li class="layui-nav-item"><a href="{{url('/')}}">@lang('user.back_index')</a></li>
            @include('common.avatar', ['id' => 'newidc-list-avatar'])
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
