@extends('client.layout')

@section('title', __('user.open_ticket'))

@section('head')
    <style>
        .w-e-menu {
            z-index: 2 !important;
        }

        .w-e-text-container {
            z-index: 1 !important;
        }

        .file-item {
            margin: 10px 0;
        }

        .layui-btn .layui-icon {
            margin-right: 0;
        }
    </style>
@endsection

@section('foot')
    <script type="text/javascript" src="{{
    asset('vendor/laravel-admin-ext/wang-editor/wangEditor-3.0.10/release/wangEditor.min.js')}}"></script>
    <script>
        var form = layui.form, layer = layui.layer, $ = layui.jquery;
        var E = window.wangEditor;
        var editor = new E('#editor');

        function ticketSubmit() {
            document.querySelector('input[name="content"]').value = editor.txt.html();
        }

        function addFile() {
            $('#files').append('<div class="file-item"><input type="file" name="files[]">' +
                '<button type="button" class="layui-btn layui-btn-xs" onclick="removeFile(this)">' +
                '<i class="layui-icon layui-icon-delete"></i>' +
                '</button></div>')
        }

        function removeFile(obj) {
            $(obj).parent().remove()
        }

        $(document).ready(function () {
            addFile();
            editor.create();
            @error('content')
            layer.open({icon: 2, content: "{{$message}}"})
            @enderror
        });
    </script>
@endsection

@section('content')
    <form class="layui-form" action="{{route('ticket.store')}}" method="post" enctype="multipart/form-data"
          onsubmit="ticketSubmit()">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label">称呼</label>
            <div class="layui-input-block">
                <input type="text" name="name" required lay-verify="required" autocomplete="off"
                       class="layui-input" value="{{$name}}" @auth disabled @endauth>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">Email</label>
            <div class="layui-input-block">
                <input type="email" name="email" required lay-verify="required|email" autocomplete="off"
                       class="layui-input" value="{{$email}}" @auth disabled @endauth>
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">标题</label>
            <div class="layui-input-block">
                <input type="text" name="title" required lay-verify="required" placeholder="请输入标题" autocomplete="off"
                       class="layui-input" value="{{old('title')}}">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label">部门</label>
            <div class="layui-input-block">
                <select name="department_id" lay-verify="required">
                    @foreach($departments as $department)
                        <option value="{{$department['id']}}"
                                @if(old('department_id')==$department['id'] || $deptid==$department['id']) selected @endif
                        >{{$department['name']}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        @auth
        <div class="layui-form-item">
            <label class="layui-form-label">相关服务</label>
            <div class="layui-input-block">
                <select name="service_id">
                    <option value=""></option>
                    @foreach($services as $service)
                        <option value="{{$service['id']}}" @if(old('service_id')==$service['id']) selected @endif
                        >{{$service->product->name}} - {{$service['name']}}({{$service->status_text}})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        @endguest
        <div class="layui-form-item">
            <label class="layui-form-label">优先级</label>
            <div class="layui-input-block">
                <select name="priority" lay-verify="required">
                    <option value="low" @if(old('priority')=='low') selected @endif>@lang('Low')</option>
                    <option value="medium" @if(old('priority', 'medium')=='medium') selected @endif>@lang('Medium')</option>
                    <option value="high" @if(old('priority')=='high') selected @endif>@lang('High')</option>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">内容</label>
            <div class="layui-input-block">
                <div id="editor">{!! old('content') !!}</div>
                <input type="hidden" name="content">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">附件</label>
            <div class="layui-input-block">
                <p>支持的文件格式：{{implode(",", array_filter(json_decode(getOption('allow_upload_ext'), true)))}}；
                支持的单个文件大小：{{getOption('max_upload_size', 2)}} MB</p>
                <div id="files"></div>
                <p>
                    <button type="button" class="layui-btn layui-btn-xs" onclick="addFile()">
                        <i class="layui-icon layui-icon-add-circle"></i>
                    </button>
                </p>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit>提交</button>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
@endsection
