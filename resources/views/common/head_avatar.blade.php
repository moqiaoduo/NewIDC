<li class="layui-nav-item">
    <a href="javascript:;">
        <img src="https://sdn.geekzu.org/avatar/@if(Auth::check()) {{md5(Auth::user()->email)}} @endif"
             class="layui-nav-img">
        @guest @lang('Guest') @else @lang('Welcome, :username',['username'=>Auth::user()->username]) @endguest
    </a>
    <dl class="layui-nav-child">
        @guest
            <dd><a href="{{route('login')}}">@lang('Login')</a></dd>
            @if(Route::has('register')) <dd><a href="{{route('register')}}">@lang('Register')</a></dd> @endif
        @else
            <dd><a href="{{route('client.index')}}">@lang('Dashboard')</a></dd>
            <dd><a href="javascript:;">@lang('user.profile')</a></dd>
            <dd><a href="javascript:;" onclick="document.getElementById('logout').submit()">@lang('Logout')</a></dd>
        @endguest
    </dl>
</li>
<form method="post" action="{{route('logout')}}" id="logout">
    @csrf
</form>
