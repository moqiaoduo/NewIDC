<li class="layui-nav-item {{$class ?? ''}}" @if(isset($id)) id="{{$id}}" @endif>
    <a href="javascript:;">
        @if(isset($avatar))
            {!! $avatar !!}
        @else
            <img src="https://sdn.geekzu.org/avatar/@if(Auth::check()) {{md5(Auth::user()->email)}} @endif"
                 class="layui-nav-img">
            @guest @lang('Guest') @else @lang('Welcome, :username',['username'=>Auth::user()->username]) @endguest
        @endif
    </a>
    <dl class="layui-nav-child">
        @guest
            <dd><a href="{{route('login')}}">@lang('Login')</a></dd>
            @if(Route::has('register'))
                <dd><a href="{{route('register')}}">@lang('Register')</a></dd> @endif
        @else
            <dd><a href="{{route('client')}}">@lang('user.area')</a></dd>
            <dd><a href="javascript:;">@lang('user.profile')</a></dd>
            <dd><a href="javascript:;" onclick="document.getElementById('logout').submit()">@lang('Logout')</a></dd>
        @endguest
    </dl>
</li>
