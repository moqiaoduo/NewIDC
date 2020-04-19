<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ServerGroup
 *
 * @property int $id
 * @property string $name
 * @property int $select_server_method 0:完全由插件接管 1:选择最少人的服务器 2:优先填满一个服务器 3:随机分配
 * @property mixed|null $servers
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereSelectServerMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereServers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ServerGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerGroup extends Model
{
    protected $casts=[
        'servers'=>'json'
    ];
}
