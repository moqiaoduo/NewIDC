<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Server
 *
 * @property int $id
 * @property string $name
 * @property string $server_plugin
 * @property string|null $hostname
 * @property string|null $ip
 * @property string|null $username
 * @property string|null $password
 * @property string|null $access_key
 * @property int $max_load
 * @property int $enable
 * @property string $api_access_address
 * @property int $api_access_ssl
 * @property int $access_ssl
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereAccessKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereAccessSsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereApiAccessAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereApiAccessSsl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereHostname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereMaxLoad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereServerPlugin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereUsername($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Service[] $services
 * @property-read int|null $services_count
 * @property int|null $port
 * @property float $monthly_cost
 * @property string|null $status_address
 * @property mixed|null $extra
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereMonthlyCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Server whereStatusAddress($value)
 */
class Server extends Model
{
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}
