<div class="row">
    <div class="col-sm-12">
        <div>
            <button type="button" class="form-control btn btn-success" id="pt-{{$name}}-addItem">
                @lang('admin.product.price.addItem')
            </button>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>
                            @lang('admin.product.price.name')
                            <i class="fa fa-question" data-toggle="tooltip"
                               title="@lang('admin.help.product.price_name')"></i>
                        </th>
                        <th style="min-width: 140px;">@lang('admin.product.price.period')</th>
                        <th>
                            @lang('admin.product.price.price')
                            <i class="fa fa-question" data-toggle="tooltip"
                               title="@lang('admin.help.product.price')"></i>
                        </th>
                        <th>@lang('admin.product.price.setup')</th>
                        <th>@lang('admin.product.price.enable')</th>
                        <th>@lang('admin.product.price.auto_activate')</th>
                        <th>@lang('admin.product.price.allow_renew')</th>
                    </tr>
                    </thead>
                    <tbody id="pt-{{$name}}-tbody">
                    @foreach((array) $value as $id => $item)
                        @include('admin.price_table_tr',['index'=>$id])
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
