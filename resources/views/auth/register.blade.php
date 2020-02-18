@extends('layout')

@section('title', '注册')

@section('head')
@endsection

@section('foot')
    <script>
        layui.use(["form"],function () {
            var form = layui.form;
        })
    </script>
@endsection

@section('content')
    <fieldset class="layui-elem-field newidc-login">
        <legend>注册</legend>
        <div class="layui-field-box">
            <form class="layui-form" method="post" action="{{route('register')}}">
                @csrf
                <div class="layui-form-item">
                    <input type="text" name="username" required lay-verify="required" placeholder="用户名（5-255个字符）"
                           class="layui-input @error('username') newidc-form-invalid @enderror" value="{{old('username')}}">
                    @error('username')
                    <span class="newidc-form-error">{{$message}}</span>
                    @enderror
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password" required lay-verify="required" placeholder="密码（至少8个字符）"
                           class="layui-input @error('password') newidc-form-invalid @enderror">
                    @error('password')
                    <span class="newidc-form-error">{{$message}}</span>
                    @enderror
                </div>
                <div class="layui-form-item">
                    <input type="password" name="password_confirmation" required lay-verify="required"
                           placeholder="确认密码" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <input type="email" name="email" required lay-verify="required|email" value="{{old('email')}}"
                           placeholder="电子邮箱" class="layui-input @error('email') newidc-form-invalid @enderror">
                    @error('email')
                    <span class="newidc-form-error">{{$message}}</span>
                    @enderror
                </div>
                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid" lay-submit>注册</button>
                </div>
            </form>
        </div>
    </fieldset>
@endsection
