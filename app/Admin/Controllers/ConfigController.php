<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
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

    protected $third_parts;

    public function __construct()
    {
        $this->save_url = route('admin.config.base');

        $this->third_parts = $this->pluginHandle()->trigger($plugged)->settings();
    }

    protected function pub(Content $body, $nowTab, $content)
    {
        $items = [
            "base" => [__('admin.config.tab.base'), 'addLink', $this->save_url, false],
            "cron" => [__('admin.config.tab.cron'), 'addLink', route('admin.config.cron'), false],
            'upload' => [__('admin.config.tab.upload'), 'addLink', route('admin.config.upload'), false],
            "template" => [__('admin.config.tab.template'), 'addLink', route('admin.config.template'), false],
        ];
        foreach ($this->third_parts as $slug=>$item) {
            $items[$slug] = [__($item['title']), 'addLink', $this->save_url . '/' . $slug, false];
        }
        if (!array_key_exists($nowTab, $items)) throw new NotFoundHttpException();
        $items[$nowTab][1] = 'add';
        $items[$nowTab][2] = $content;
        $items[$nowTab][3] = true;
        $tab = new Tab();
        foreach ($items as $item) {
            [$t, $m, $c, $a] = $item;
            $tab->$m($t, $c, $a);
        }
        return $body
            ->title(__('admin.config.title'))
            ->description(__('admin.config.tip'))
            ->row($tab);
    }

    protected function form(Content $content, $nowTab, Closure $func)
    {
        $form = new Form();
        $form->method('POST')->action($this->save_url);
        $func($form);
        foreach ($form->fields() as $field) {
            $column = $field->column();
            if (empty($column)) continue;
            if (substr($column, 0, 4) === 'env.') {
                $column = substr($column, 4);
                $envs[$column] = env($column);
            } elseif (substr($column, 0, 7) === 'option.') {
                $configs[] = substr($column, 7);
            }
        }
        foreach (getOptions($configs ?? []) as $key => $option) {
            $tmp = json_decode($option, true);
            if (json_last_error() == JSON_ERROR_NONE) $options[$key] = $tmp;
            else $options[$key] = $option;
        }
        $form->fill(['env' => $envs ?? [], 'option' => $options ?? []]);
        return $this->pub($content, $nowTab, $form);
    }

    public function index(Content $content)
    {
        return $this->form($content, 'base', function (Form $form) {
            $form->text('env.APP_NAME', __('admin.config.app_name'))->required();
            $form->email('option.admin_email', __('admin.config.admin_email'))
                ->help(__('admin.help.config.admin_email'));
            $form->url('env.APP_URL', __('admin.config.url'))->required()
                ->help(__('admin.help.config.url'));
            $form->switch('option.register', __('admin.config.register'));
            $form->switch('option.tos', __('admin.config.tos'))->help(__('admin.help.config.tos'));
            $form->url('option.tos_url', __('admin.config.tos_url'));
            $form->radio('option.service_username_generation', __('admin.config.sug'))
                ->options(['random' => __('admin.config.sug_random'), 'domain' => __('admin.config.sug_domain')])
                ->help(__('admin.help.config.sug'))->default('random');
            $form->switch('option.site_service_username_unique', __('admin.config.site_suu'))
                ->help(__('admin.help.config.site_suu'));
            $form->switch('option.site_service_domain_unique', __('admin.config.site_sdu'))
                ->help(__('admin.help.config.site_sdu'));
            $form->number('option.limit_activity_log', __('admin.config.limit_activity_log'))
                ->help(__('admin.help.config.limit_activity_log'))->default(1000);
        });
    }

    public function cron(Content $content)
    {
        return $this->form($content, 'cron', function (Form $form) {
            $form->switch('option.cron', __('admin.config.cron'));
            $form->switch('option.suspend', __('admin.config.suspend'));
            $form->number('option.suspend_days', __('admin.config.suspend_days'))
                ->default(0)->min(0)->help(__('admin.help.config.suspend_days'));
            $form->switch('option.send_suspension_email', __('admin.config.send_suspension_email'))
                ->help(__('admin.help.config.send_suspension_email'));
            $form->switch('option.unsuspension', __('admin.config.enable_unsuspension'))
                ->help(__('admin.help.config.unsuspension'));
            $form->switch('option.send_unsuspension_email', __('admin.config.send_unsuspension_email'))
                ->help(__('admin.help.config.send_unsuspension_email'));
            $form->switch('option.terminate', __('admin.config.terminate'));
            $form->number('option.terminate_days', __('admin.config.terminate_days'))
                ->default(3)->min(0)->help(__('admin.help.config.termination_days'));
        });
    }

    public function upload(Content $content)
    {
        return $this->form($content, 'upload', function (Form $form) {
            $form->tags('option.allow_upload_ext', __('admin.config.allow_upload_ext'))
                ->help(__('admin.help.config.allow_upload_ext'));
            $form->number('option.max_upload_size', __('admin.config.max_upload_size'))
                ->help(__('admin.help.config.max_upload_size'))->default(2);
        });
    }

    public function template(Content $content)
    {
        return $this->form($content, 'template', function (Form $form) {
            $form->select('env.TEMPLATE', __('admin.config.template'))
                ->options(arrayKeyValueSame(Storage::disk('template')->allDirectories()))
                ->help(__('admin.help.config.template'));
            $form->divider(__('admin.help.config.tpl_settings'));
            if (empty(env('TEMPLATE'))) {
                $options = [];
                foreach (ProductGroup::with('products')->get() as $group) {
                    $groupName = $group->name;
                    $options = $options + $group->products
                            ->pluck('name', 'id')->map(function ($name) use ($groupName) {
                                return $groupName . ' - ' . $name;
                            })->toArray();
                }
                $form->multipleSelect('option.template_default_home_product',
                    __('admin.config.tpl_home_product'))->config('maximumSelectionLength', 4)
                    ->options($options)->help(__('admin.help.config.tpl_hp'));
            } else {
                $settings_file = storage_path('app/templates/' . env('TEMPLATE') . '/settings.php');
                if (file_exists($settings_file)) $configs = include ($settings_file) ?? [];
                else $configs = [];
                buildFormFromArr($configs, $form, 'option.');
            }

        });
    }

    public function third_part(Content $content)
    {
        return $this->form($content, $plugin = \request()->route()->fallbackPlaceholder, function (Form $form) use ($plugin) {
            $configs = $this->third_parts[$plugin]['form'] ?? [];

            buildFormFromArr((array) $configs, $form, 'option.' . $plugin . '_');
        });
    }

    public function save(Request $request)
    {
        $options = str_replace(['on', 'off'], [1, 0], $request->post('option', []));
        $envs = str_replace(['on', 'off'], [1, 0], $request->post('env', []));
        foreach ($options as $key => $val) {
            setOption($key, is_array($val) ? json_encode($val) : $val);
        }
        modifyEnv($envs);
        admin_toastr(__('admin.save_succeeded'));
        return back();
    }
}
