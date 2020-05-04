<li class="layui-nav-item">
    <a href="javascript:;">
        {{config('lang.locations.'.App::getLocale(),App::getLocale())}}
    </a>
    <dl class="layui-nav-child">
        @foreach(config('lang.locations') as $lang => $show)
            <dd><a href="{{route('locale', ['lang' => $lang])}}">{{$show}}</a></dd>
        @endforeach
    </dl>
</li>
@include('common.avatar', ['id' => 'newidc-head-avatar'])
<form method="post" action="{{route('logout')}}" id="logout">
    @csrf
</form>
