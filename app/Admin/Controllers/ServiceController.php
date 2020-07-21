<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Server;
use App\Models\ServerGroup;
use App\Models\Service;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $title = 'Services';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Service());

        $grid->model()->orderBy('created_at', 'desc');

        $grid->column('id', 'ID')->sortable();
        $grid->column('product_id', __('Product'))->display(function ($id) {
            if ($product = Product::find($id))
                return ($product->group ? $product->group->name . ' - ' : '') . $product->name;
        })->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('user', __('User'))->display(function ($user) {
            return '<a href="' . route('admin.user.show', $user['id']) . '">' . $user['username'] . '</a>';
        });
        $grid->column('username', __('Username'))->sortable();
        $grid->column('domain', __('Domain'))->sortable();
        $grid->column('status', __('Status'))->display(function () {
            return $this->status_text;
        })->label([
            'active' => 'success',
            'suspended' => 'warning',
            'pending' => 'info',
            'terminated' => 'danger',
            'cancelled' => 'default'
        ])->sortable();
        $grid->column('expire_at', __('Next Due Date'))->sortable();
        $grid->column('created_at', __('Created at'))->sortable();

        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });

        return $grid;
    }

    public function create(Content $content)
    {
        $form = '';

        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($form);
    }

    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->row(view('admin.service.command_form', ['id' => $id]))
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Service());

        $form->html(view('admin.service.command'), __('admin.service.commands.name'));

        $groups = [];
        foreach (ProductGroup::with('products')->get() as $group) {
            $groups[] = ['label' => $group->name, 'options' => $group->products->pluck('name', 'id')];
        }
        $form->select('product_id', __('Product'))->groups($groups)->required();

        $groups = [];
        foreach (ServerGroup::all() as $group) {
            $servers = Server::findMany($group->servers);
            $groups[] = ['label' => $group->name, 'options' => $servers->pluck('name', 'id')];
        }
        $form->select('server_id', __('Server'))->groups($groups);

        $form->select('user_id', __('User'))->options(function ($id) {
            if ($id && $user = User::find($id))
                return [$user->id => $user->username . ' - #' . $user->id];
        })->ajax('/admin/api/users')->required();
        $form->text('name', __('Name'));
        $form->text('domain', __('Domain'));
        $form->text('username', __('Username'));
        $form->password('password', __('Password'));
        $form->select('status', __('Status'))->options(__('service.status'))->required();
        $form->datetime('expire_at', __('Next Due Date'));

        $form->embeds('extra', __('admin.service.fields.extra'), function (Form\EmbeddedForm $form) {
            $form->switch('auto_terminate_end_of_cycle',
                __('admin.service.fields.auto_terminate_end_of_cycle'));
            $form->text('cancel_reason', __('admin.service.fields.cancel_reason'));
            $form->text('suspend_reason', __('admin.service.fields.suspend_reason'));

        });

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 默认勾选`继续编辑`
            $footer->checkEditing();
        });

        return $form;
    }

    public function serverCommand(Request $request, Service $service, $command = null)
    {
        $server = $service->server;

        if (empty($server)) {
            admin_toastr('还未分配服务器', 'error'); // TODO: 国际化
            return back();
        }

        $class = $server->server_plugin;

        if (empty($command)) $command = $request->input('command');

        if (class_exists($class)) {
            $plugin = new $class;
            /* @var \NewIDC\Plugin\Server $plugin */
            $plugin->init($service->product, $service, $server);
            $result = $plugin->command($command, $request->input('payload'));
            if ($result['code']) {
                admin_toastr(str_replace(PHP_EOL, '', $result['msg']), 'error');
            } else {
                admin_toastr('命令执行成功'); // TODO: 国际化
            }
        } else {
            admin_toastr('未找到插件', 'error'); // TODO: 国际化
        }

        return back();
    }
}
