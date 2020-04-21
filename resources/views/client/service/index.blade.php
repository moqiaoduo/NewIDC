@extends('client.layout')

@section('title', __('My Services'))

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
        layui.use(['table','form'], function () {
            var table = layui.table,
                form = layui.form;

            //转换静态表格
            table.init('table', {
                limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
                , page: true
                , skin: 'line'
                , text: {none: '暂无服务'}
                , toolbar: '#tools'
                , defaultToolbar: []
            });

            table.on('row(table)', function (obj) {
                window.location.href = obj.data.link
            });

            form.on('select(status)', function(){
                document.getElementById('service-table-form').submit()
            });
        })
    </script>
    <script type="text/html" id="tools">
        <form class="layui-form" method="get" id="service-table-form">
            <div class="layui-inline">
                <label class="layui-form-label">筛选</label>
                <div class="layui-input-inline">
                    <select lay-filter="status" name="status">
                        <option value="">@lang('All')</option>
                        @foreach(__('service.status') as $key=>$val)
                            <option value="{{$key}}"
                                    @if(request()->get('status')==$key) selected @endif>{{$val}}</option>
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
            <th lay-data="{field: 'product', sort: true}">产品/服务</th>
            <th lay-data="{field: 'price', sort: true, width: 150}">价格</th>
            <th lay-data="{field: 'expire_at', sort: true, width: 200}">下次付款时间</th>
            <th lay-data="{field: 'status', sort: true, width: 100}">状态</th>
            <th lay-data="{field: 'op', width: 170}"></th>
            <th lay-data="{field: 'link', hide: true}"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>
                    <p>{{$item->product->group->name}} - {{$item->product->name}}</p>
                    <p><a href="{{route('client.service',$item)}}">{{$item->name}}</a></p>
                </td>
                <td>
                    @if($item->price['type'] == 'free')
                        <p>免费</p>
                    @else
                        <p>￥{{$item->price['price']}}</p>
                    @endif
                    @lang('price.'.$item->price['period']['name'])
                </td>
                <td>{{$item->expire_at}}</td>
                <td>
                    <span class="layui-badge-dot {{$item->status_color}}"></span>
                    {{$item->status_text}}
                </td>
                <td>
                    <div class="layui-btn-group">
                        <a href="" class="layui-btn layui-btn-normal">续费</a>
                        <a href="{{route('client.service',$item)}}" class="layui-btn layui-btn-primary">管理</a>
                    </div>
                </td>
                <td>{{route('client.service',$item)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
