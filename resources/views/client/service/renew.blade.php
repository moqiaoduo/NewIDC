<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@lang('Renew')</title>
    <link rel="stylesheet" href="{{asset('vendor/laravel-admin/AdminLTE/bootstrap/css/bootstrap.min.css')}}">
</head>
<body>
<div class="text-center">
    @if($disable)
        <p>该服务无法续费</p>
    @else
        <p>
            您当前的产品价格为
            @if($free)
                @lang('Free')
            @else
                ￥{{$service->price['price']}}
            @endif
            ，续费周期为 @lang('price.'.$service->price['period']['name'])
        </p>
        <p>
            每 {{$service->price['period']['num']}}
            @lang('period.'.$service->price['period']['unit']) 需支付
            ￥{{sprintf("%.2f", $service->price['price'])}}
        </p>
        @if($free && !$free_renew)
            <p>由于产品的限制，当前暂时不能续费，请在到期前{{$limit_days}}天再尝试。</p>
        @else
            <form method="post" action="{{route('service.renew', $service)}}">
                @csrf
                <button class="btn btn-success">续费</button>
            </form>
        @endif
    @endif


</div>
<script src="{{asset('vendor/laravel-admin/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
<script src="{{asset('vendor/laravel-admin/AdminLTE/bootstrap/js/bootstrap.min.js')}}"></script>
</body>
</html>
