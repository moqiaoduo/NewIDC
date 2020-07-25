<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\TicketDetail
 *
 * @property int $id
 * @property int $user_id
 * @property int $ticket_id
 * @property string $content
 * @property mixed|null $attachments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereAttachments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $admin
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TicketDetail whereAdmin($value)
 */
class TicketDetail extends Model
{
    protected $casts = [
        'attachments' => 'json'
    ];

    public function user()
    {
        return $this->admin ? $this->belongsTo(Administrator::class) : $this->belongsTo(User::class);
    }
}
