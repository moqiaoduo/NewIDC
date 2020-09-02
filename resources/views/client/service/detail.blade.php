@extends('client.layout')

@section('title', __('My Service #:id', ['id' => $service->id]))

@section('head')
    <style>
        .newidc-service-status h3:not(:first-of-type) {
            margin-top: 10px;
        }

        .newidc-service-status h3 {
            font-weight: bold;
        }
    </style>
@endsection

@section('foot')
    <script>
        var $ = layui.jquery, form = layui.form;

        form.verify({
            pass_confirm: function (value) {
                console.log(form.val('change-password'))
                if (value !== form.val('change-password').password) {
                    return '密码与确认密码不符'
                }
            }
        });

        function generate_password() {
            var text = ['abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', '1234567890', '~!@#$%^&*()_+";",./?<>'];
            var rand = function (min, max) {
                return Math.floor(Math.max(min, Math.random() * (max + 1)));
            }
            var pw = '';
            for (var i = 0; i < 16; ++i) {
                var strpos = rand(0, 3);
                pw += text[strpos].charAt(rand(0, text[strpos].length));
            }
            var index = layer.open({
                title: '密码生成成功'
                , content: '新密码：' + pw + '，点击确定填写到输入框'
                , yes: function () {
                    form.val('change-password', {
                        password: pw,
                        password_confirmation: pw
                    })
                    layer.close(index)
                }
            });
        }

        $(document).ready(function () {
            @error('change_password')
            layer.alert('{{$message}}')
            @enderror

            @if(session()->has('success'))
            layer.msg('{{session('success')}}')
            @endif
        })
    </script>
@endsection

@section('content')
    <div class="layui-tab layui-tab-brief" lay-filter="docDemoTabBrief">
        <ul class="layui-tab-title">
            <li class="layui-this">@lang('Overview')</li>
            <li>@lang('Change Password')</li>
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
                            <div class="layui-field-box newidc-service-status" style="text-align: center;">
                                <h3>创建日</h3>
                                <p>{{\Carbon\Carbon::parse($service->created_at)->toDateString()}}</p>
                                <h3>循环出账金额</h3>
                                <p>{{$service->price['type']=='free'?'免费':'￥'.$service->price['price']}}</p>
                                <h3>出账周期</h3>
                                <p>@lang('price.'.$service->price['period']['name'])</p>
                                <h3>下次到期日</h3>
                                <p>{{$service->expire_at ? \Carbon\Carbon::parse($service->expire_at)->toDateString() : '-'}}</p>
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
                    <div class="layui-tab-content">
                        <div class="layui-tab-item layui-show">
                            <table class="newidc-service-info">
                                <tbody>
                                @if($service->status == 'active')
                                <tr>
                                    <td>用户名</td>
                                    <td>{{$service->username}}</td>
                                </tr>
                                <tr>
                                    <td>密码</td>
                                    <td>{{$service->password}}</td>
                                </tr>
                                <tr>
                                    <td>IP地址</td>
                                    <td>{{$service->server->ip}}</td>
                                </tr>
                                {{-- 这个地方预计插入info hook --}}
                                <tr class="newidc-service-login">
                                    <td colspan="2">
                                        {!! $login !!}
                                    </td>
                                </tr>
                                @endif
                                <tr class="newidc-service-login">
                                    <td colspan="2">
                                        <a href="{{route('service.renew', $service)}}"
                                           class="layui-btn layui-btn-normal">续费</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="layui-tab-item">
                <form class="layui-form" lay-filter="change-password" method="post"
                      action="{{route('service.change_pwd',$service)}}">
                    @csrf
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="width: 250px;">
                            <input type="password" name="password" required lay-verify="required"
                                   class="layui-input" placeholder="@lang('New Password')">
                        </div>
                        <div class="layui-word-aux">
                            <button class="layui-btn layui-btn-normal" onclick="generate_password()" type="button">
                                @lang('Generate Password')</button>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline" style="width: 250px;">
                            <input type="password" name="password_confirmation" class="layui-input" required
                                   lay-verify="required|pass_confirm" placeholder="@lang('Confirm New Password')">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <button class="layui-btn" lay-submit>@lang('Save Changes')</button>
                        <button type="reset" class="layui-btn layui-btn-primary">@lang('Cancel')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
