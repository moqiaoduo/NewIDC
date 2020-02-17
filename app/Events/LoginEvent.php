<?php

namespace Illuminate\Auth\Events;

use App\Models\User;
use Illuminate\Queue\SerializesModels;

class LoginEvent
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var User
     */
    public $user;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}
