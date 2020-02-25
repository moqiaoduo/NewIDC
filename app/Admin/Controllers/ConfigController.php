<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Closure;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Form;
use Encore\Admin\Widgets\Tab;
use Illuminate\Http\Request;
use PluginManager;
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
        foreach (PluginManager::trigger(['hook'=>'settings','returnArray'=>true]) as $item) {
            list($slug,$name) = explode("|",$item);
            $items[$slug]=[$name,'addLink',$this->save_url.'/'.$slug,false];
        }
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
            $form->switch('register',__('admin.config.register'));
            $form->switch('tos',__('admin.config.tos'))->help(__('admin.help.config.tos'));
            $form->url('tos_url',__('admin.config.tos_url'));
            $form->radio('service_username_generation',__('admin.config.sug'))->default('random')
                ->options(['random'=>__('admin.config.sug_random'),'domain'=>__('admin.config.sug_domain')])
                ->help(__('admin.help.config.sug'));
            $form->switch('site_service_username_unique',__('admin.config.site_suu'))
                ->help(__('admin.help.config.site_suu'));
            $form->switch('site_service_domain_unique',__('admin.config.site_sdu'))
                ->help(__('admin.help.config.site_sdu'));
            $form->email('admin_email',__('admin.config.admin_email'))
                ->help(__('admin.help.config.admin_email'));
        });
    }

    public function cron(Content $content)
    {
        return $this->form($content,'cron',function (Form $form) {
            $form->switch('cron',__('admin.config.cron'));
            $form->html(__('admin.help.config.cron'));
            $form->switch('suspend_expire',__('admin.config.suspend_expire'));
            $form->number('suspend_after_days',__('admin.config.suspend_after_days'))
                ->default(0)->min(0);
            $form->switch('terminate_expire',__('admin.config.terminate_expire'));
            $form->number('terminate_after_days',__('admin.config.terminate_after_days'))
                ->default(3)->min(0);
        });
    }

    public function template(Content $content)
    {
        return $this->form($content,'template',function (Form $form) {
            $form->select('template',__('admin.config.template'))
                ->options(arrayKeyValueSame(Storage::disk('template')->allDirectories()))
                ->help(__('admin.help.config.template'));
            $form->divider(__('admin.help.config.tpl_settings'));
            $template=getOption('template');
            if (empty($template)) {
                $form->multipleSelect('template_default_home_product',__('admin.config.tpl_home_product'))
                    ->options(function ($ids) {
                        if ($ids)
                            return Product::find($ids)->pluck('name', 'id');
                    })->ajax('/admin/api/products')->config('maximumSelectionLength',4)
                    ->help(__('admin.help.config.tpl_hp'));
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
        return $this->form($content,$page=\request()->route()->fallbackPlaceholder,function (Form $form) use ($page) {
            $configs=PluginManager::trigger(['hook'=>$page.'_settings','last'=>true]);
            foreach ((array) $configs as $key=>$config) {
                $type=$config['type'];
                $label=$config['label'];
                unset($config['type'],$config['label']);
                $t=$form->$type($key,$label);
                foreach ($config as $k=>$v) {
                    $t->$k($v);
                }
            }
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
        admin_toastr(__('admin.save_succeeded'));
        return back();
    }
}
