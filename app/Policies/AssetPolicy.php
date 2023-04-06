<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
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
     * Determines if a given user can view a given asset
     * 
     * @param App\Models\User $user : The requesting user
     * @param App\Models\Asset $asset : The asset
     */
    public function view(User $user, Asset $asset)
    {
        // Deny all if entry has not been unlocked yet
        if ($asset->entry->unlock_id === null)
            return false;

        // Allow access if the user belongs to the entry's vault
        return $user->vaults()->where('vault_id', $asset->entry->vault->id)->get()->isNotEmpty();
    }
}
