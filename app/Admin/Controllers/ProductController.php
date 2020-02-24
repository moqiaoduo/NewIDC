<?php

namespace App\Admin\Controllers;

use App\Models\Product;
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

        $form->tab(__('Base info'), function (Form $form) {
            $form->text('name', __('Name'));
            $form->text('type', __('Type'));
            $form->select('product_group_id', __('Product group'));
            $form->textarea('description', __('Description'));
            $form->switch('hide', __('Hide'));
            $form->switch('enable', __('Enable'))->default(1);
            $form->number('order', __('Priority'))->default(0)
                ->help(__('admin.help.product.order'));
        })->tab(__('Price'), function (Form $form) {
            $form->table('price',__('Price'),function (Form\NestedForm $table) {
                $table->text('name',__('Name'));
                $table->text('period',__('Period'));
                $table->text('price',__('Price'));
                $table->checkbox('options',__('Options'))->options([
                    'enable'=>__('Enable'),
                    'auto_activate'=>__('Automatic activate'),
                    'allow_renew'=>__('Allow to use renewing')
                ]);
            });
        })->tab(__('Upgrade').'/'.__('Downgrade'),function (Form $form) {

        })->tab(__('Server'), function (Form $form) {
            $info=PluginManager::getList();
            foreach (PluginManager::getServerPluginList() as $plugin) {
                $plugins[$plugin]=$info[$plugin]['name']??$plugin;
            }
            $form->select('server_plugin', __('Server plugin'))->options($plugins??[]);
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
        })->tab(__('Domain'),function (Form $form) {
            $form->tags('free_domain', __('Free domain'));
        })->tab(__('Others'),function (Form $form) {
            $form->text('extra', __('Extra'));
        });

        $form->footer(function (Form\Footer $footer) {
            // 默认勾选`继续编辑`
            $footer->checkEditing();
        });

        return $form;
    }
}
