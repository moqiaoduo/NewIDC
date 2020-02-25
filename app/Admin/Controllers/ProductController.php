<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\ProductGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use PluginManager;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '产品管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->filter(function($filter){
            // 在这里添加字段过滤器
            $filter->like('name', __('Name'));
            $filter->in('product_group_id',__('Product group'))->multipleSelect('/admin/api/products');
            $filter->in('type',__('Type'))->multipleSelect(__('type'));
            $filter->equal('hide',__('Hide'))->radio([
                ''   => '不限',
                1    => '是',
                0    => '否',
            ]);
            $filter->equal('enable', __('Enable'))->radio([
                ''   => '不限',
                1    => '是',
                0    => '否',
            ]);
            $filter->between('created_at', __('Created at'))->datetime();
            $filter->between('updated_at', __('Updated at'))->datetime();
        });

        $grid->column('id', __('Id'))->sortable();
        $grid->column('group.name', __('Product group'));
        $grid->column('name', __('Name'));
        $grid->column('type', __('Type'))->using(__('type'));
        $grid->column('description', __('Description'));
        $grid->column('hide', __('Hide'))->sortable()->switch();
        $grid->column('enable', __('Enable'))->sortable()->switch();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_group_id', __('Product group id'));
        $show->field('name', __('Name'));
        $show->field('type', __('Type'));
        $show->field('description', __('Description'));
        $show->field('hide', __('Hide'));
        $show->field('enable', __('Enable'));
        $show->field('price', __('Price'));
        $show->field('config', __('Config'));
        $show->field('server_plugin', __('Server plugin'));
        $show->field('server_id', __('Server id'));
        $show->field('free_domain', __('Free domain'));
        $show->field('extra', __('Extra'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->tab(__('admin.product.tab.base'), function (Form $form) {
            $form->text('name', __('Name'))->required();
            $form->select('type', __('Type'))->options(__('type'))->required();
            $form->select('product_group_id', __('Product group'))->required()
                ->options(function ($id) {
                    if ($id && $group=ProductGroup::find($id))
                        return [$group->id => $group->name . '(GID:' . $group->id . ')'];
                })->ajax('/admin/api/product_groups');
            $form->editor('description', __('Description'));
            $form->switch('require_domain',__('admin.product.domain.require'))
                ->help(__('admin.help.product.require_domain'));
            $form->switch('ena_stock',__('admin.product.ena_stock'))
                ->help(__('admin.help.product.ena_stock'));
            $form->number('stocks',__('Stocks'))->default(0);
            $form->number('order', __('Priority'))->default(0)
                ->help(__('admin.help.product.order'));
            $form->switch('hide', __('Hide'));
            $form->switch('enable', __('Enable'))->default(1);
        })->tab(__('admin.product.tab.price'), function (Form $form) {
            $form->price('price');
            $form->embeds('price_configs','',function (Form\EmbeddedForm $form) {

            });
        })->tab(__('admin.product.tab.api'), function (Form $form) {
            $info=PluginManager::getList();
            foreach (PluginManager::getServerPluginList() as $plugin) {
                $plugins[$plugin]=$info[$plugin]['name']??$plugin;
            }
            $form->select('server_plugin', __('admin.product.server.plugin'))->options($plugins??[]);
            $form->select('server_id', __('Server'))->load('city', '/api/city');
            $plugin=$form->model()->value('server_plugin');
            $form->embeds('config.server',__('Settings'),function ($form) use ($plugin) {
                if (class_exists($plugin)) {
                    $configs=$plugin::productConfig();
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
        })->tab(__('Upgrade').'/'.__('Downgrade'),function (Form $form) {
            $form->embeds('upgrade_downgrade_config','',function (Form\EmbeddedForm $form) {
                $form->switch('enable',__('admin.config.enable_udg'));
            });
        })->tab(__('Domain'),function (Form $form) {
            $form->embeds('domain_configs','',function (Form\EmbeddedForm $form) {
                $form->tags('free_domain', __('admin.product.domain.free'))
                    ->help(__('admin.help.product.free_domain'));
            });
        })->tab(__('Others'),function (Form $form) {

        });

        $form->footer(function (Form\Footer $footer) {
            // 默认勾选`继续编辑`
            $footer->checkEditing();
        });

        $form->saving(function (Form $form) {
            $price_table=[];
            foreach ($form->price as $price) {
                if (empty($price['name'])) continue;
                $price_table[]=[
                    'name'=>$price['name'],
                    'period'=>$price['period'],
                    'period_unit'=>$price['period_unit'],
                    'price'=>$price['price'],
                    'remark'=>$price['remark'],
                    'enable'=>isset($price['enable']),
                    'auto_activate'=>isset($price['auto_activate']),
                    'allow_renew'=>isset($price['allow_renew'])
                ];
            }
            $form->price=$price_table;
        });

        return $form;
    }
}
