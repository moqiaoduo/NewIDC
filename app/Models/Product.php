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
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereServerPlugin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereGroupId($value)
 * @property-read \App\Models\ProductGroup $group
 * @property int $require_domain
 * @property int $ena_stock
 * @property int $rest_stock
 * @property mixed|null $price_configs 价格配置
 * @property mixed|null $server_configs 服务器插件配置
 * @property mixed|null $upgrade_downgrade_config 升降级配置
 * @property mixed|null $domain_configs 域名配置
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDomainConfigs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereEnaStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePriceConfigs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereRequireDomain($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereRestStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereServerConfigs($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpgradeDowngradeConfig($value)
 * @property int|null $stocks
 * @property int|null $server_group_id
 * @property-read \App\Models\ServerGroup|null $server_group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereServerGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereStocks($value)
 */
class Product extends Model
{
    protected $casts=[
        'price'=>'json',
        'price_configs'=>'json',
        'server_configs'=>'json',
        'upgrade_downgrade_config'=>'json',
        'domain_configs'=>'json',
        'extra'=>'json'
    ];

    public function group()
    {
        return $this->belongsTo(ProductGroup::class);
    }

    public function server_group()
    {
        return $this->belongsTo(ServerGroup::class);
    }

    public function getCleanDescription() {
        return str_replace(["\r\n","\r","\n"],'<br>',
            preg_replace('/(\s+\r)/',"",$this->description));
    }
}
