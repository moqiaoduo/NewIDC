<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $type hosting: 虚机,reseller: 分销,vps: VPS,server:独服,others:其他
 * @property string|null $description
 * @property int $hide
 * @property int $enable
 * @property mixed|null $price 价格表
 * @property mixed|null $config
 * @property int $order
 * @property string|null $server_plugin
 * @property int $server_id
 * @property string|null $free_domain
 * @property mixed|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereConfig($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFreeDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereServerPlugin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Product extends Model
{
    //
}
