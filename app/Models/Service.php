<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $username
 * @property string|null $password
 * @property string|null $domain
 * @property int $server_id
 * @property string $status pending:待开通 active:运行中 suspended:已暂停 terminated:已销毁 cancelled:已取消
 * @property string|null $expire_at
 * @property mixed|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Service whereUsername($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\Server $server
 */
class Service extends Model
{
    protected $fillable = ['status'];

    protected $casts=[
        'extra'=>'json'
    ];

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 待开通、激活、暂停状态
     *
     * @param $query
     */
    public function scopeUsing($query)
    {
        $query->whereIn('status', ['pending', 'active', 'suspended']);
    }
}
