Copyright © {{now()->year}} {{config('app.name')}}. All rights reserved. |
Powered by <a href="https://github.com/moqiaoduo/NewIDC" target="_blank">NewIDC</a>
<form id="lang" method="get" action="{{route('locale')}}">
    @csrf
    <select name="lang" onchange="submit()">
        <option value="zh-CN">简体中文</option>
        <option value="en">English</option>
    </select>
</form>
