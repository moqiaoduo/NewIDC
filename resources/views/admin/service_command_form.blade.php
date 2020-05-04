<form method="post" action="{{route('admin.service.command', ['service' => $id])}}">
    @csrf
    <div class="modal fade" id="serviceCreate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">@lang('admin.service.commands.modal_title')</h4>
                </div>
                <div class="modal-body">
                    @lang('admin.service.commands.modal_body',['command'=>__('admin.service.commands.create')])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" name="command" value="create" class="btn btn-primary">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <div class="modal fade" id="serviceSuspend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">@lang('admin.service.commands.modal_title')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('admin.service.commands.modal_body',['command'=>__('admin.service.commands.suspend')])</p>
                    <div class="row">
                        <label class="col-sm-4 control-label">Suspension Reason:</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="payload[suspend_reason]">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-4 col-sm-8">
                            <label><input type="checkbox" name="payload[mail]" value="1">Send Suspension Email</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" name="command" value="suspend" class="btn btn-primary">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <div class="modal fade" id="serviceUnsuspend" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">@lang('admin.service.commands.modal_title')</h4>
                </div>
                <div class="modal-body">
                    <p>@lang('admin.service.commands.modal_body',['command'=>__('admin.service.commands.unsuspend')])</p>
                    <p><label><input type="checkbox">Send Unsuspension Email</label></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" name="command" value="unsuspend" class="btn btn-primary">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <div class="modal fade" id="serviceTerminate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">@lang('admin.service.commands.modal_title')</h4>
                </div>
                <div class="modal-body">
                    @lang('admin.service.commands.modal_body',['command'=>__('admin.service.commands.terminate')])
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" name="command" value="terminate" class="btn btn-primary">Yes</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</form>
