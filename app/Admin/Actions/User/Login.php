<?php

namespace App\Admin\Actions\User;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Login extends RowAction
{
    public $name = '登录';

    public function href()
    {
        return 'javascript:window.open("' . $this->getResource() . '/' . $this->getKey() . '/login");';
    }

}
