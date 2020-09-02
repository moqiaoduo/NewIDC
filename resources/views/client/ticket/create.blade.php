@extends('client.layout')

@section('title', __('user.open_ticket'))

@section('head')
@endsection

@section('foot')
@endsection

@section('content')
    <h1>选择部门</h1>
    <p>提示：选择正确的部门，有助于您的问题能快速解决。</p>
    <div class="layui-row layui-col-space20 newidc-margin-top20">
        @foreach($departments as $department)
        <div class="layui-col-md6">
            <h3>
                <a href="?step=2&deptid={{$department['id']}}">
                    <i class="layui-icon layui-icon-email"></i>
                    {{$department['name']}}
                </a>
            </h3>
            <p style="margin: 10px 0;">{!! nl2br($department['description']) !!}</p>
        </div>
        @endforeach
    </div>
@endsection
