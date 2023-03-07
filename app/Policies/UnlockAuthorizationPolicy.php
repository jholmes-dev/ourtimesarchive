<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UnlockAuthorization;
use Illuminate\Auth\Access\HandlesAuthorization;

class UnlockAuthorizationPolicy
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
     * Determines if a given user can access the unlock authorization
     * 
     * @param App\Models\User
     * @param App\Models\UnlockAuthorization
     */
    public function access(User $user, UnlockAuthorization $uAuth)
    {
        return $uAuth->user_id == $user->id;
    }

}
