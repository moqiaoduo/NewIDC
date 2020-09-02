@extends('client.layout')

@section('title', __('user.ticket_show'))

@section('head')
    <style>
        .layui-card {
            border: 1px solid #eee;
        }
        .layui-card-header {
            background-color: #f5f5f5;
        }
        #ticket-info {
            padding: 0;
        }
        #ticket-info .item {
            list-style: none;
            padding: 10px;
        }
        #ticket-info .item:not(:last-of-type) {
            border-bottom: 1px solid #f5f5f5;
        }
        #ticket-info .footer {
            background-color: #f5f5f5;
            text-align: center;
        }
        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
        }
        .ticket-detail-item .layui-card-header {
            display: flex;
            justify-content: space-between;
        }
        .file-item {
            margin: 10px 0;
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
    <div class="layui-row layui-col-space20">
        <div class="layui-col-md3">
            <div class="layui-card">
                <div class="layui-card-header">工单信息</div>
                <div class="layui-card-body" style="padding: 0;">
                    <ul id="ticket-info">
                        <li class="item">
                            <div>工单状态</div>
                            <div><span class="label" style="background-color: {{$ticket['status_color']}}">{{$ticket['status_text']}}</span></div>
                        </li>
                        <li class="item">
                            <div>部门</div>
                            <div>{{$ticket->department->name}}</div>
                        </li>
                        <li class="item">
                            <div>建立时间</div>
                            <div>{{$ticket['created_at']}}</div>
                        </li>
                        <li class="item">
                            <div>最后更新</div>
                            <div>{{$ticket['updated_at']}}</div>
                        </li>
                        <li class="item">
                            <div>优先级</div>
                            <div>{{$ticket['priority_text']}}</div>
                        </li>
                        <li class="item footer">
                            <form method="post" action="{{route('ticket.destroy', $ticket)}}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="layui-btn"
                                        onclick="document.querySelector('#reply').click()">回复</button>
                                <button type="submit" class="layui-btn layui-btn-danger">关闭工单</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="layui-col-md9">
            <h1 style="text-align: center;">{{$ticket['title']}}</h1>
            <div class="layui-collapse" style="margin: 20px 0;">
                <div class="layui-colla-item">
                    <h2 class="layui-colla-title" id="reply">回复</h2>
                    <div class="layui-colla-content">
                        <form class="layui-form" action="{{route('ticket.update', $ticket)}}" method="post"
                              enctype="multipart/form-data" onsubmit="ticketSubmit()">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="check_code" value="{{$ticket->check_code}}">
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
                                    <p>支持的文件格式：{{implode(",", array_filter(json_decode(
    getOption('allow_upload_ext'), true)))}}； 支持的单个文件大小：{{getOption('max_upload_size', 2)}} MB</p>
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
                    </div>
                </div>
            </div>
            @foreach($ticket->contents()->orderByDesc('created_at')->get() as $item)
                @php
                    $user = $item->user;
                @endphp
                <div class="layui-card ticket-detail-item">
                    <div class="layui-card-header">
                        <span>
                            @if($item['admin'])
                                {{$user->name}}(Stuff)
                            @elseif($user)
                                {{$user->username}}(Client)
                            @else
                                {{$ticket['name']}}(Client)
                            @endif
                        </span>
                        <span>
                            {{$item['created_at']}}
                        </span>
                    </div>
                    <div class="layui-card-body">
                        {!! $item['content'] !!}
                        @if(!empty($item['attachments']))
                            <p>附件：</p>
                            @foreach($item['attachments'] as $file=>$url)
                                @php($mime = Storage::disk('public')->mimeType($url))
                                <p>
                                    <a target="_blank" href="{{Storage::disk('public')->url($url)}}">
                                        @if(substr($mime, 0, 5) == 'image')
                                            <i class="layui-icon layui-icon-picture"></i>
                                        @else
                                            <i class="layui-icon layui-icon-file"></i>
                                        @endif
                                        {{$file}}
                                    </a>
                                </p>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
