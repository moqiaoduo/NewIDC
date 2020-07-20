<form method="post" action="{{route('admin.service.command', ['service' => $id])}}">
    @csrf
    @include('admin.service.modal.create')
    @include('admin.service.modal.suspend')
    @include('admin.service.modal.unsuspend')
    @include('admin.service.modal.terminate')
</form>
