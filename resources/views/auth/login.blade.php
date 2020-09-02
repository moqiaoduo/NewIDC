@extends('layout')

@section('title', '登录')

@section('head')
@endsection

@section('foot')
@endsection

@section('content')
    <fieldset class="layui-elem-field newidc-login">
        <legend>登录</legend>
        <div class="layui-field-box">
            <form class="layui-form" method="post" action="{{route('login')}}">
                @csrf
                <div class="layui-form-item">
                    <input type="text" name="email" required lay-verify="required" value="{{old('email')}}"
                           placeholder="用户名/邮箱" class="layui-input @error('email') newidc-form-invalid @enderror">
                    @error('email')
                    <span class="newidc-form-error">{{$message}}</span>
                    @enderror
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password" required lay-verify="required"
                           placeholder="密码" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <input type="checkbox" name="remember" title="记住我" lay-skin="primary">
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid" lay-submit>登录</button>
                </div>
            </form>
        </div>
    </fieldset>
@endsection
