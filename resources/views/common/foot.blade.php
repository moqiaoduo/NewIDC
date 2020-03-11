Copyright © {{now()->year}} {{config('app.name')}}. All rights reserved. |
Powered by <a href="https://github.com/moqiaoduo/NewIDC" target="_blank">NewIDC</a>
<form id="lang" method="get" action="{{route('locale')}}">
    <select name="lang" onchange="submit()">
        <option value="zh-CN" @if(App::isLocale('zh-CN')) selected @endif>简体中文</option>
        <option value="en" @if(App::isLocale('en')) selected @endif>English</option>
    </select>
</form>
