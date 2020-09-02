<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Invoice
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $user_id
 * @property mixed $items
 * @property mixed|null $services
 * @property float $subtotal
 * @property float $credit
 * @property float $total
 * @property string|null $payment
 * @property string $status
 * @property string|null $expire_at
 * @property string|null $paid_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereItems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice wherePayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereServices($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Invoice whereUserId($value)
 */
class Invoice extends Model
{
    //
}
