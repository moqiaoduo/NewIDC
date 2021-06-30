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
use Encore\Admin\Widgets\Box;
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

        $grid->model()->orderBy('created_at', 'desc')->with('product.group');

        $grid->column('id', 'ID')->sortable();
        $grid->column('product_id', __('Product'))->display(function () {
            if ($product = $this->product)
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
        $step = request('step', 1);
        $form = '';

        switch ($step) {
            case 1:
                // 取所有产品
                $form = new Box('创建服务第一步：选择产品');
                $frm = new \Encore\Admin\Widgets\Form();
                $frm->action(route('admin.service.create.next', ['step' => 2]));
                $frm->select('product_id', '产品')->groups($this->makeProductGroups())->required();
                $form->content($frm->render());
                break;
            case 2:
                $product = Product::findOrFail(request('product_id'));
                $service = new Service();
                $form = new Form($service);
                $form->setAction(route('admin.service.store'));
                $form->hidden('product_id')->default($product->id);
                $form->select('server_id', __('Server'))
                    ->groups($this->makeServerGroups())->default(null);
                $form->select('user_id', __('User'))->options(function ($id) {
                    if ($id && $user = User::find($id))
                        return [$user->id => $user->username . ' - #' . $user->id];
                })->ajax('/admin/api/users')->required();
                $form->text('name', __('Name'));
                $form->text('domain', __('Domain'));
                $form->text('username', __('Username'));
                $form->password('password', __('Password'));
                $form->datetime('expire_at', __('Next Due Date'));
                $form->checkbox('extra', __('admin.service.fields.extra'))
                    ->options(['activate' => '创建后开通']);
                break;
        }


        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($form);
    }

    public function store()
    {
        $service = new Service();
        $service->product_id = request()->post('product_id');
        $service->user_id = request()->post('user_id');
        $service->server_id = request()->post('server_id');
        $service->name = request()->post('name');
        $service->username = request()->post('username');
        $service->password = request()->post('password');
        $service->domain = request()->post('domain');
        $service->expire_at = request()->post('expire_at');
        $service->save();

        $extra = request()->post('extra');
        if (in_array('activate', $extra)) {
            $this->serverCommand(request(), $service, 'create');
        }
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

        $form->select('product_id', __('Product'))->groups($this->makeProductGroups())->required();

        $form->select('server_id', __('Server'))->groups($this->makeServerGroups())->default(null);

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
