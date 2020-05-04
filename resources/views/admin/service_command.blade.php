<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#serviceCreate">
    @lang('admin.service.commands.create')
</button>
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#serviceSuspend">
    @lang('admin.service.commands.suspend')
</button>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#serviceUnsuspend">
    @lang('admin.service.commands.unsuspend')
</button>
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#serviceTerminate">
    @lang('admin.service.commands.terminate')
</button>
<a class="btn btn-default"
   href="{{route('admin.service.command',['service'=>request()->route('service'),'command'=>'change_password'])}}">
    @lang('Change Password')
</a>
