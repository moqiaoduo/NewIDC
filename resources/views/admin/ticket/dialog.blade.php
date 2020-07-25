@foreach($data as $item)
    @php
    $user = $item->user;
    @endphp
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                @if($item['admin'])
                    {{$user->username}}(Stuff)
                @else
                    <a href="{{route('admin.user.show', $user)}}">{{$user->username}}</a>(Client)
                @endif
            </h3>
            <div class="box-title pull-right">
                {{$item['created_at']}}
            </div><!-- /.box-tools -->
        </div><!-- /.box-header -->
        <div class="box-body" style="display: block;">
            {!! $item['content'] !!}
            @if(!empty($item['attachments']))
                <p>附件：</p>
                @foreach($item['attachments'] as $file=>$url)
                    @php($mime = Storage::disk('public')->mimeType($url))
                    <p>
                        <a target="_blank" href="{{Storage::disk('public')->url($url)}}">
                            @if(substr($mime, 0, 5) == 'image')
                                <i class="fa fa-image"></i>
                            @else
                                <i class="fa fa-file"></i>
                            @endif
                            {{$file}}
                        </a>
                    </p>
                @endforeach
            @endif
        </div><!-- /.box-body -->
    </div>
@endforeach
