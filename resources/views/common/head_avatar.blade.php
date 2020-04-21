@include('common.avatar', ['id' => 'newidc-head-avatar'])
<form method="post" action="{{route('logout')}}" id="logout">
    @csrf
</form>
