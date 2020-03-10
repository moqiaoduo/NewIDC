<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

use App\Admin\Extensions\PriceTable;
use Encore\Admin\Form;

Form::forget(['map']);

Form::extend('price', PriceTable::class);

Admin::navbar(function (\Encore\Admin\Widgets\Navbar $navbar) {
    $list='';$url=route('admin.setting');
    foreach (Storage::disk('lang')->allDirectories() as $directory) {
        $active=$directory===request()->user('admin')->lang?' class="active"':"";
        $list.=<<<HTML
        <li role="presentation"$active>
			<a role="menuitem" tabindex="-1" href="javascript:;" onclick="changeLang('$directory')"
			>$directory</a>
		</li>
HTML;

    }

    $navbar->right(<<<HTML
<style>
.open .lang-fast {
width: 244px;
display: flex;
flex-flow: wrap;
}
.lang-fast li {
width: 80px;
}
</style>
<script>
function changeLang(lang) {
    $.ajax({
        url: '$url',
        method: 'POST',
        data: {
            lang:lang,
            _method:'PUT',
            _token:LA.token
        },
        success:function(data){
            window.location.reload()
        }
    });
}
</script>
<li>
    <a href="#" id="lang-fast" data-toggle="dropdown">
        <i class="fa fa-language"></i>
    </a>
    <ul class="dropdown-menu lang-fast" role="menu" aria-labelledby="lang-fast">
$list
	</ul>
</li>

HTML
);

});
