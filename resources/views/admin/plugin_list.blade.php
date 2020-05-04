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
                    <p>{{$info['description']}}</p>
                    <div>
                        <button class="btn btn-default" disabled>默认启用</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
