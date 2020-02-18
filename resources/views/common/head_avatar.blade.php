<li class="layui-nav-item">
    <a href="javascript:;">
        <img src="https://sdn.geekzu.org/avatar/@if(Auth::check()) {{md5(Auth::user()->email)}} @endif"
             class="layui-nav-img">
        @guest 未登录 @else 欢迎, {{Auth::user()->username}} @endguest
    </a>
    <dl class="layui-nav-child">
        @guest
            <dd><a href="{{route('login')}}">登录</a></dd>
            <dd><a href="{{route('register')}}">注册</a></dd>
        @else
            <dd><a href="javascript:;">修改信息</a></dd>
            <dd><a href="javascript:;">安全管理</a></dd>
            <dd><a href="javascript:;" onclick="document.getElementById('logout').submit()">登出</a></dd>
        @endguest
    </dl>
</li>
<form method="post" action="{{route('logout')}}" id="logout">
    @csrf
</form>
