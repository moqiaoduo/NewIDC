<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Department
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $email
 * @property mixed $assign
 * @property int $client_only
 * @property int $hide
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereAssign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereClientOnly($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereHide($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Department whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read int|null $users_count
 */
class Department extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
