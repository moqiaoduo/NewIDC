<div class="row">
    <div class="col-sm-12">
        <div>
            <button type="button" class="form-control btn btn-success" id="pt-{{$name}}-addItem">
                @lang('admin.product.price.addItem')
            </button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        @lang('admin.product.price.name')
                        <i class="fa fa-question" data-toggle="tooltip"
                           title="@lang('admin.help.product.price_name')"></i>
                    </th>
                    <th>@lang('admin.product.price.period')</th>
                    <th>@lang('admin.product.price.price')</th>
                    <th>@lang('admin.product.price.remark')</th>
                    <th>@lang('admin.product.price.enable')</th>
                    <th>@lang('admin.product.price.auto_activate')</th>
                    <th>@lang('admin.product.price.allow_renew')</th>
                </tr>
                </thead>
                <tbody id="pt-{{$name}}-tbody">
                @foreach((array) $value as $item)
                    @include('admin.price_table_tr',['index'=>$loop->index])
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
