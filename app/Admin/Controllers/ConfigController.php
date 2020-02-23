<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Closure;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfigController extends Controller
{
    protected $save_url;

    public function __construct()
    {
        $this->save_url = route('admin.config.base');
    }

    protected function pub(Content $body,$nowTab,$content)
    {
        $items = [
            "base"=>['基础设置','addLink',$this->save_url,false],
            "cron"=>['计划任务设置','addLink',route('admin.config.cron'),false],
            "template"=>['模板设置','addLink',route('admin.config.template'),false],
        ];
        if (!array_key_exists($nowTab,$items)) throw new NotFoundHttpException();
        $items[$nowTab][1]='add';
        $items[$nowTab][2]=$content;
        $items[$nowTab][3]=true;
        $tab=new Tab();
        foreach ($items as $item) {
            [$t,$m,$c,$a] = $item;
            $tab->$m($t,$c,$a);
        }
        return $body
            ->title("网站设置")
            ->description('切换选项卡之前先保存哦')
            ->row($tab);
    }

    protected function form(Content $content,$nowTab,Closure $func)
    {
        $form=new Form();$configs=[];
        $form->method('POST')->action($this->save_url);
        $func($form);
        foreach ($form->fields() as $field) {
            $configs[]=$field->column();
        }
        $form->fill(getOptions($configs));
        return $this->pub($content,$nowTab,$form);
    }

    public function index(Content $content)
    {
        return $this->form($content,'base',function (Form $form) {
            $form->switch('tos','服务条款(TOS)')->help('启用后，用户注册/购买产品需要先同意服务条款');
            $form->url('tos_url','服务条款URL');
            $form->radio('service_username_generation','服务用户名生成方式')
                ->options(['random'=>'随机用户名','domain'=>'从域名生成'])->default('random')
                ->help('若选择“随机用户名”，则会生成sxxxxxxx样子的用户名（s加7个数字）;
        若选择“从域名生成”，则会取域名中所有字母，若有重复则后加1');
            $form->switch('site_service_username_unique','全站服务用户名惟一')
                ->help('启用后，整个服务表不允许出现相同用户名的服务（启用之前不算）');
            $form->switch('site_service_domain_unique','全站服务域名惟一')
                ->help('启用后，整个服务表不允许出现相同域名的服务（启用之前不算）');
            $form->email('admin_email','管理员邮箱')->help('用于接收系统邮件(如工单提醒)');
        });
    }

    public function cron(Content $content)
    {
        return $this->form($content,'cron',function (Form $form) {
            $form->switch('cron','启用计划任务');
            $form->html("注意：暂停和停止时间是同时计时的，若时间一致，则优先停止服务");
            $form->switch('suspend_expire','暂停过期服务');
            $form->number('suspend_after_days','过期n天后暂停')->default(0)->min(0);
            $form->switch('terminate_expire','停止过期服务');
            $form->number('terminate_after_days','过期n天后停止')->default(3)->min(0);
        });
    }

    public function template(Content $content)
    {
        return $this->form($content,'template',function (Form $form) {
            $form->select('template','使用模板')->options(arrayKeyValueSame(Storage::disk('template')
                ->allDirectories()))->help('点击叉号将其置空则使用默认模板');
            $form->divider('下面是模板设置（保存后刷新）');
            $template=getOption('template');
            if (empty($template)) {
                $form->multipleSelect('template_default_home_product','首页显示推荐产品')
                    ->options(function ($ids) {
                        if ($ids)
                            return Product::find($ids)->pluck('name', 'id');
                    })->ajax('/admin/api/products')->config('maximumSelectionLength',4)
                    ->help('选中的产品将在首页展示，最多4个');
            } else {
                $settings_file=storage_path('app/templates/'.$template.'/settings.php');
                if (file_exists($settings_file)) $configs=include($settings_file)??[];
                else $configs=[];
                foreach ($configs as $key=>$config) {
                    $type=$config['type'];
                    $label=$config['label'];
                    unset($config['type'],$config['label']);
                    $t=$form->$type($key,$label);
                    foreach ($config as $k=>$v) {
                        $t->$k($v);
                    }
                }
            }

        });
    }

    public function third_part(Content $content)
    {
        return $this->form($content,\request()->route()->fallbackPlaceholder,function (Form $form) {

        });
    }

    public function save(Request $request)
    {
        $options=$request->post();
        unset($options['_token']);
        $options=str_replace("on",1,$options);
        $options=str_replace("off",0,$options);
        foreach ($options as $key=>$val) {
            setOption($key,$val);
        }
        admin_toastr("保存成功");
        return back();
    }
}
