<div class="row">
    @foreach($plugins as $plugin=>$info)
        <div class="col-sm-6 col-md-4 col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{$info['name']}}
                    </h3>
                </div>
                <div class="panel-body">
                    <p>@lang('Version') : {{$info['version'] ?? 'Unknown'}}</p>
                    <p>{{$info['description'] ?? null}}</p>
                    <div>
                        <form method="post" action="{{route('admin.plugin.manage')}}">
                            <input type="hidden" name="plugin" value="{{$plugin}}">
                            @if(PluginManager::isServerPlugin($plugin))
                                <button class="btn btn-default" disabled>默认启用</button>
                            @elseif(PluginManager::isEnable($plugin))
                                <input type="hidden" name="enable" value="0">
                                <button type="submit" class="btn btn-danger">禁用</button>
                            @else
                                <input type="hidden" name="enable" value="1">
                                <button type="submit" class="btn btn-success">启用</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
