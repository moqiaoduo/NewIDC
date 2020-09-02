<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property int $user_id
 * @property string $title
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TicketDetail[] $contents
 * @property-read int|null $contents_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $department_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereDepartmentId($value)
 * @property string $priority
 * @property-read mixed $status_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket wherePriority($value)
 * @property-read mixed $status_color
 * @property-read \App\Models\TicketStatus $statusR
 * @property-read \App\Models\Department|null $department
 * @property-read mixed $priority_text
 * @property int|null $service_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereServiceId($value)
 * @property string $name
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereName($value)
 * @property string $check_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ticket whereCheckCode($value)
 */
class Ticket extends Model
{
    private $status_model;

    protected $appends = ['status_text', 'status_color', 'priority_text'];

    protected $fillable = ['status'];

    public function contents()
    {
        return $this->hasMany(TicketDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function statusR()
    {
        return $this->belongsTo(TicketStatus::class, 'status');
    }

    public function getStatusTextAttribute()
    {
        if (is_null($this->status_model))
            $this->status_model = $this->statusR()->first();

        return \App\Utils\Ticket::titleTrans($this->status_model->title);
    }

    public function getStatusColorAttribute()
    {
        if (is_null($this->status_model))
            $this->status_model = $this->statusR()->first();

        return $this->status_model->color;
    }

    public function getPriorityTextAttribute()
    {
        switch ($this->priority) {
            case 'low':
                return __('Low');
            case 'medium':
                return __('Medium');
            case 'high':
                return __('High');
            default:
                return $this->priority;
        }
    }
}
