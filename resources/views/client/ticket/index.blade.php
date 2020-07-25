@extends('client.layout')

@section('title', __('user.ticket'))

@section('head')
    <style>
        .layui-table-cell {
            height: auto;
            text-overflow: inherit;
            overflow: visible;
            white-space: normal;
            word-wrap: break-word;
        }

        .layui-table td {
            cursor: pointer !important;
        }
    </style>
@endsection

@section('foot')
    <script>
        layui.use(['table', 'form', 'jquery'], function () {
            var table = layui.table,
                form = layui.form,
                $ = layui.jquery;

            //转换静态表格
            table.init('table', {
                limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
                , page: true
                , skin: 'line'
                , toolbar: '#tools'
                , defaultToolbar: []
                , initSort: {
                    field: 'updated_at' //排序字段，对应 cols 设定的各字段名
                    , type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
                }
            });

            table.on('row(table)', function (obj) {
                window.location.href = obj.data.link
            });

            form.on('select(status)', function () {
                document.getElementById('ticket-table-form').submit()
            });
        })
    </script>
    <script type="text/html" id="tools">
        <form class="layui-form" method="get" id="ticket-table-form">
            <div class="layui-inline">
                <label class="layui-form-label" style="width: 60px;">筛选</label>
                <div class="layui-input-inline">
                    <select lay-filter="status" name="status">
                        <option value="">@lang('All')</option>
                        @foreach($ticket_statuses as $item)
                            <option value="{{$item['id']}}"
                                    @if($status==$item['id']) selected @endif
                            >{{\App\Utils\Ticket::titleTrans($item['title'])}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </script>
@endsection

@section('content')
    <table lay-filter="table">
        <thead>
        <tr>
            <th lay-data="{field: 'department', sort: true, width: 150}">部门</th>
            <th lay-data="{field: 'title', sort: true}">标题</th>
            <th lay-data="{field: 'status', sort: true, width: 100}">状态</th>
            <th lay-data="{field: 'updated_at', sort: true, width: 200}">最后更新</th>
            <th lay-data="{field: 'op', width: 100}"></th>
            <th lay-data="{field: 'link', hide: true}"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>{{$item->department->name}}</td>
                <td>
                    <p>#{{$item->id}}</p>
                    <p><a href="{{route('service',$item)}}">{{$item->title}}</a></p>
                </td>
                <td>
                    <span class="layui-badge-dot" style="background-color: {{$item->status_color}}!important;"></span>
                    {{$item->status_text}}
                </td>
                <td>{{$item->updated_at}}</td>
                <td>
                    <div class="layui-btn-group">
                        <a href="{{route('ticket.show',$item)}}"
                           class="layui-btn layui-btn-primary">@lang('Show')</a>
                    </div>
                </td>
                <td>{{route('ticket.show',$item)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
