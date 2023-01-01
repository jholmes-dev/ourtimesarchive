<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Invite;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if user can respond to the invite
     * 
     * @param App\Models\User $user
     * @param App\Models\Invite $invite
     */
    public function respond(User $user, Invite $invite)
    {
        return $user->email == $invite->to;
    }

}
