<button type="button" id="reset-password" class="btn btn-success">@lang('Reset & Send Password')</button>

<script>
    $(function() {
        $("#reset-password").on('click',function () {
            $.ajax({
                url: '{{route('admin.user.reset_success',request()->route()->parameter('user'))}}',
                method: 'POST',
                data: {_token:LA.token},
                success: function () {
                    toastr.success('@lang('admin.user.reset_success')')
                },
                error: function () {
                    toastr.error('An error occurred')
                }
            })
        })
    });
</script>
