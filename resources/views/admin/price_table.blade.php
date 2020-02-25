<div class="row">
    <div class="col-sm-12">
        <div>
            <button type="button" class="form-control btn btn-success" id="pt-{{$name}}-addItem">
                @lang('admin.product.price.addItem')
            </button>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>@lang('admin.product.price.name')</th>
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
                    <tr>
                        <td>
                            <input type="text" name="{{$name}}[{{$loop->index}}][name]" class="form-control"
                                   value="{{$item['name']}}">
                        </td>
                        <td>
                            <input type="text" name="{{$name}}[{{$loop->index}}][period]" class="form-control"
                                   style="width: calc(100% - 65px);display: inline-block;" value="{{$item['period']}}">
                            <select name="{{$name}}[{{$loop->index}}][period_unit]" class="form-control"
                                    style="width: 60px;display: inline-block;">
                                <option value="day" @if($item['period_unit']=='day') selected @endif>天</option>
                                <option value="month" @if($item['period_unit']=='month') selected @endif>月</option>
                                <option value="year" @if($item['period_unit']=='year') selected @endif>年</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="{{$name}}[{{$loop->index}}][price]" class="form-control"
                                   value="{{$item['price']}}">
                        </td>
                        <td>
                            <input type="text" name="{{$name}}[{{$loop->index}}][remark]" class="form-control"
                                   value="{{$item['remark']}}">
                        </td>
                        <td>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="{{$name}}[{{$loop->index}}][enable]" class="pt-checkbox"
                                       @if($item['enable']) checked @endif />
                            </label>
                        </td>
                        <td>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="{{$name}}[{{$loop->index}}][auto_activate]"
                                       class="pt-checkbox" @if($item['auto_activate']) checked @endif />
                            </label>
                        </td>
                        <td>
                            <label class="checkbox-inline">
                                <input type="checkbox" name="{{$name}}[{{$loop->index}}][allow_renew]"
                                       class="pt-checkbox" @if($item['allow_renew']) checked @endif />
                            </label>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
