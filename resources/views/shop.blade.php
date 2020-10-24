@extends('layout')

@section('title', __('Store'))

@section('head')
    <style>
        .layui-body {
            background: #eeeeee;
        }
        .newidc-product-description {
            vertical-align: top;
            display: inline-block;
            width: 60%;
        }
        .newidc-product-price {
            vertical-align: top;
            display: inline-block;
            text-align: center;
        }
    </style>
@endsection

@section('foot')
@endsection

@section('content')
    <div class="layui-row" style="text-align: center;">
        @foreach($groups as $group)
            <a href="?gid={{$group['id']}}" class="layui-btn @if($gid != $group['id']) layui-btn-primary @endif">
                {{$group['name']}}
            </a>
        @endforeach
    </div>
    <div class="layui-row layui-col-space20 newidc-margin-top20">
        @foreach($data as $val)
            <div class="layui-col-sm6 layui-col-md4">
                <div class="layui-card">
                    <div class="layui-card-header">
                        {{$val['name']}}
                    </div>
                    <div class="layui-card-body">
                        <div class="newidc-product-description">
                            {!! $val->getCleanDescription() !!}
                        </div>
                        <div class="newidc-product-price">
                            <p>{{getLowestPrice($product['price'])}} Start</p>
                            <a href="{{route('buy', $val->id)}}" class="layui-btn">@lang('Buy NOW')</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
