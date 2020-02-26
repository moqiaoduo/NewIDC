<tr>
    <td>
        <input type="text" name="{{$name}}[{{$index}}][name]" class="form-control"
               value="{{$item['name']??null}}" list="name-list" autocomplete="off">
        <datalist id="name-list">
            <option value="$daily">@lang('admin.product.price.$daily')</option>
            <option value="$monthly">@lang('admin.product.price.$monthly')</option>
            <option value="$quarterly">@lang('admin.product.price.$quarterly')</option>
            <option value="$semi-annually">@lang('admin.product.price.$semi-annually')</option>
            <option value="$annually">@lang('admin.product.price.$annually')</option>
            <option value="$unlimited">@lang('admin.product.price.$unlimited')</option>
        </datalist>
    </td>
    <td>
        <input type="text" name="{{$name}}[{{$index}}][period]" class="form-control"
               style="width: calc(100% - 105px);display: inline-block;" value="{{$item['period']??null}}">
        <select name="{{$name}}[{{$index}}][period_unit]" class="form-control"
                style="width: 100px;display: inline-block;">
            <option value="day" @if(($pu=($item['period_unit']??null))=='day') selected @endif>
                @lang('admin.product.price.day')
            </option>
            <option value="month" @if($pu=='month') selected @endif>
                @lang('admin.product.price.month')
            </option>
            <option value="year" @if($pu=='year') selected @endif>
                @lang('admin.product.price.year')
            </option>
            <option value="unlimited" @if($pu=='unlimited') selected @endif>
                @lang('admin.product.price.unlimited')
            </option>
        </select>
    </td>
    <td>
        <input type="text" name="{{$name}}[{{$index}}][price]" class="form-control" value="{{$item['price']??null}}">
    </td>
    <td>
        <input type="text" name="{{$name}}[{{$index}}][remark]" class="form-control" value="{{$item['remark']??null}}">
    </td>
    <td>
        <label class="checkbox-inline">
            <input type="checkbox" name="{{$name}}[{{$index}}][enable]" class="pt-checkbox"
                   @if($item['enable']??null) checked @endif />
        </label>
    </td>
    <td>
        <label class="checkbox-inline">
            <input type="checkbox" name="{{$name}}[{{$index}}][auto_activate]"
                   class="pt-checkbox" @if($item['auto_activate']??null) checked @endif />
        </label>
    </td>
    <td>
        <label class="checkbox-inline">
            <input type="checkbox" name="{{$name}}[{{$index}}][allow_renew]"
                   class="pt-checkbox" @if($item['allow_renew']??null) checked @endif />
        </label>
    </td>
</tr>
