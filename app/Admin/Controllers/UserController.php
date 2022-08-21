<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\User\Login;
use App\Models\Product;
use App\Models\User;
use App\Notifications\ResetPassword;
use Encore\Admin\Form;
use Encore\Admin\Form\Builder;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Str;

class UserController extends Controller
{
    protected $title = 'Users';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('username', __('Username'));
        $grid->column('email', __('Email'));
        $grid->column('funds', __('Funds'));
        $grid->column('last_logon_at', __('admin.user.last_logon_at'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->actions(function ($actions) {
            $actions->add(new Login());
        });

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('username', __('Username'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('admin.user.email_verified_at'));
        $show->field('funds', __('Funds'));
        $show->field('last_logon_at', __('admin.user.last_logon_at'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
        $show->field('login', __('Login'))->unescape()->as(function () use ($show) {
            return '<a href="' . $show->getResourcePath() . '/' . $this->id . '/login' .
                '" target="_blank" class="btn btn-success">以该用户身份登录</a>';
        });

        $show->services(__('Services'), function ($service) {

            $service->resource('/admin/service');

            $service->id('ID');
            $service->product_id(__('Product'))->display(function ($id) {
                if ($product = Product::find($id))
                    return ($product->group ? $product->group->name . ' - ' : '') . $product->name;
            });
            $service->name();
            $service->username();
            $service->domain();
            $service->status()->display(function () {
                return $this->status_text;
            })->label([
                'active' => 'success',
                'suspended' => 'warning',
                'pending' => 'info',
                'terminated' => 'danger',
                'cancelled' => 'default'
            ]);
            $service->expire_at();
            $service->created_at();

            $service->actions(function ($actions) {
                // 去掉查看
                $actions->disableView();
            });

        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('username', __('Username'))->required();
        $form->email('email', __('Email'))->required();
        $form->datetime('email_verified_at', __('admin.user.email_verified_at'));
        if ($form->isEditing())
            $form->html(view('admin.reset_pwd'), __('Reset Password'));
        $form->decimal('funds', __('Funds'))->default(0)->required();

        return $form;
    }

    public function store()
    {
        $user = new User();
        $user->username = request()->post('username');
        $user->password = Hash::make($password = Str::random());
        $user->email = request()->post('email');
        $user->funds = request()->post('funds', 0);
        $user->save();

        admin_success('用户创建成功', "用户名：{$user->username}<br>密码：{$password}");

        $resourcesPath = route('admin.user.index');
        $key = $user->getKey();

        if (request('after-save') == 1) {
            // continue editing
            $url = rtrim($resourcesPath, '/')."/{$key}/edit";
        } elseif (request('after-save') == 2) {
            // continue creating
            $url = rtrim($resourcesPath, '/').'/create';
        } elseif (request('after-save') == 3) {
            // view resource
            $url = rtrim($resourcesPath, '/')."/{$key}";
        } else {
            $url = request(Builder::PREVIOUS_URL_KEY) ?: $resourcesPath;
        }

        return redirect($url);
    }

    public function reset_password($id)
    {
        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($new_pwd = Str::random())]);
        $user->notify(new ResetPassword($user->username, $new_pwd));
        return 'ok';
    }

    public function login(User $user)
    {
        \Auth::guard('web')->login($user);

        return redirect('/client');
    }
}
