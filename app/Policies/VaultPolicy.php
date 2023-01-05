<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vault;
use Illuminate\Auth\Access\HandlesAuthorization;

class VaultPolicy
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
     * Determines if a given user can access a given vault
     * 
     * @param App\Models\User $user : The requesting user
     * @param App\Models\Vault $vault : The requesting vault
     */
    public function access(User $user, Vault $vault)
    {
        return $user->vaults()->where('vault_id', $vault->id)->get()->isNotEmpty();
    }
}
