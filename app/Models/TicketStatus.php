<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketStatus
 *
 * @property int $id
 * @property string $title
 * @property int $active
 * @property int $awaiting
 * @property int $auto_close
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereAutoClose($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereAwaiting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $color
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketStatus whereColor($value)
 */
class TicketStatus extends Model
{
    protected $table = 'ticket_status';
}
