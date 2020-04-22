@extends('client.layout')

@section('title', __('My Service #:id', ['id' => $service->id]))

@section('head')
@endsection

@section('foot')
@endsection

@section('content')
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">@lang('service.detail.tab.overview')</li>
            <li>@lang('service.detail.tab.change_password')</li>
            {{-- 这个地方预计插入hook --}}
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <div class="layui-row layui-col-space20">
                    <div class="layui-col-md6">
                        <fieldset class="layui-elem-field">
                            <legend>产品/域名</legend>
                            <div class="layui-field-box" style="text-align: center;">
                                <h3>{{$service->product->group->name}}</h3>
                                <p>{{$service->product->name}}</p>
                                <p><a href="http://{{$service->domain}}">{{$service->domain}}</a></p>
                                <p class="newidc-margin-top20">
                                    <a href="http://{{$service->domain}}" target="_blank"
                                       class="layui-btn layui-btn-sm">访问网站</a>
                                    <a href="https://who.is/whois/{{$service->domain}}" target="_blank"
                                       class="layui-btn layui-btn-sm layui-btn-normal">WHOIS信息</a>
                                </p>
                            </div>
                        </fieldset>
                    </div>
                    <div class="layui-col-md6">
                        <fieldset class="layui-elem-field">
                            <legend>服务概况</legend>
                            <div class="layui-field-box" style="text-align: center;">
                                <h3>创建时间</h3>
                                <p>{{$service->created_at}}</p>
                                <h3>循环出账金额</h3>
                                <p>{{$service->price['type']=='free'?'免费':'￥'.$service->price['price']}}</p>
                                <h3>出账周期</h3>
                                <p>@lang('price.'.$service->price['period']['name'])</p>
                                <h3>下次到期日</h3>
                                <p>{{$service->expire_at ?: '-'}}</p>
                                <h3>状态</h3>
                                <p><span class="layui-badge {{$service->status_color}}">
                                        {{$service->status_text}}
                                    </span>
                                </p>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="layui-tab layui-tab-card">
                    <ul class="layui-tab-title">
                        <li class="layui-this">管理</li>
                    </ul>
                    <div class="layui-tab-content" style="height: 100px;">
                        <div class="layui-tab-item layui-show">
                            <table class="newidc-service-info">
                                <tbody>
                                <tr>
                                    <td>用户名</td>
                                    <td>{{$service->username}}</td>
                                </tr>
                                <tr>
                                    <td>密码</td>
                                    <td>{{decrypt($service->password)}}</td>
                                </tr>
                                <tr>
                                    <td>IP地址</td>
                                    <td>{{$service->server->ip}}</td>
                                </tr>
                                {{-- 这个地方预计插入hook --}}
                                <tr class="newidc-service-login">
                                    <td colspan="2">
                                        {!! $login !!}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-tab-item">内容2</div>
        </div>
    </div>
@endsection
