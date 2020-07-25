<style>
    #ticket-info {
        padding: 0;
    }
    #ticket-info .item {
        list-style: none;
        padding: 10px;
    }
    #ticket-info .item:not(:last-of-type) {
        border-bottom: 1px solid #f5f5f5;
    }
</style>
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">工单信息</h3>
        <div class="box-tools pull-right">
        </div><!-- /.box-tools -->
    </div><!-- /.box-header -->
    <div class="box-body" style="display: block;padding: 0;">
        <ul id="ticket-info">
            <li class="item">
                <div>工单状态</div>
                <div><span class="label" style="background-color: {{$ticket['status_color']}}">{{$ticket['status_text']}}</span></div>
            </li>
            <li class="item">
                <div>部门</div>
                <div>{{$ticket->department->name}}</div>
            </li>
            <li class="item">
                <div>建立时间</div>
                <div>{{$ticket['created_at']}}</div>
            </li>
            <li class="item">
                <div>最后更新</div>
                <div>{{$ticket['updated_at']}}</div>
            </li>
            <li class="item">
                <div>优先级</div>
                <div>{{$ticket['priority_text']}}</div>
            </li>
        </ul>
    </div><!-- /.box-body -->
</div>
<form method="post" action="{{route('admin.ticket.update', $ticket)}}">
    @csrf
    @method('PUT')
    <input type="hidden" name="status" value="6">
    <button class="btn btn-danger">关闭工单</button>
</form>
