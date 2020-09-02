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
        var table = layui.table,
            form = layui.form,
            $ = layui.jquery;

        //转换静态表格
        table.init('table', {
            limit: 10 //注意：请务必确保 limit 参数（默认：10）是与你服务端限定的数据条数一致
            , page: true
            , skin: 'line'
            , initSort: {
                field: 'status' //排序字段，对应 cols 设定的各字段名
                , type: 'asc' //排序方式  asc: 升序、desc: 降序、null: 默认排序
            }
        });

        table.on('row(table)', function (obj) {
            window.location.href = obj.data.link
        });

        form.on('select(status)', function () {
            document.getElementById('service-table-form').submit()
        });

        $(".renew").on('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            layer.open({
                type: 2,
                title: '@lang('Renew')',
                shadeClose: true,
                shade: 0.6,
                area: ['350px', '80%'],
                content: e.target.href //iframe的url
            });
        })
    </script>
@endsection

@section('content')
    <form class="layui-form" method="get" id="service-table-form">
        <div class="layui-inline">
            <label class="layui-form-label" style="width: 60px;">筛选</label>
            <div class="layui-input-inline">
                <select lay-filter="status" name="status">
                    <option value="">@lang('All')</option>
                    @foreach(__('service.status') as $key=>$val)
                        <option value="{{$key}}"
                                @if($status==$key) selected @endif>{{$val}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    <table lay-filter="table">
        <thead>
        <tr>
            <th lay-data="{field: 'product', sort: true}">产品/服务</th>
            <th lay-data="{field: 'price', sort: true, width: 150}">价格</th>
            <th lay-data="{field: 'expire_at', sort: true, width: 150}">下次付款日</th>
            <th lay-data="{field: 'status', sort: true, width: 100}">状态</th>
            <th lay-data="{field: 'op', width: 200}"></th>
            <th lay-data="{field: 'link', hide: true}"></th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>
                    <p>{{$item->product->group->name}} - {{$item->product->name}}</p>
                    <p><a href="{{route('service',$item)}}">{{$item->name}}</a></p>
                </td>
                <td>
                    @if($item->price['type'] == 'free')
                        <p>@lang('Free')</p>
                    @else
                        <p>￥{{$item->price['price']}}</p>
                    @endif
                    @lang('price.'.$item->price['period']['name'])
                </td>
                <td>{{$item->expire_at ? \Carbon\Carbon::parse($item->expire_at)->toDateString() : '-'}}</td>
                <td>
                    <span class="layui-badge-dot {{$item->status_color}}"></span>
                    {{$item->status_text}}
                </td>
                <td>
                    <div class="layui-btn-group">
                        <a href="{{route('service.renew',$item)}}"
                           class="layui-btn layui-btn-normal renew">@lang('Renew')</a>
                        <a href="{{route('service',$item)}}"
                           class="layui-btn layui-btn-primary">@lang('Manage')</a>
                    </div>
                </td>
                <td>{{route('service',$item)}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
