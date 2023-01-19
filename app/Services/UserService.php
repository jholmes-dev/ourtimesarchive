<?php

namespace App\Services;

use App\Models\Vault;
use App\Models\User;
use App\Services\VaultService;

class UserService 
{
    
    /**
     * Vault service class
     * 
     * @var App\Services\VaultService
     */
    private $vaultService;

    /**
     * Constructs a new service
     */
    public function __construct(VaultService $vaultService) 
    {
        $this->vaultService = $vaultService;
    } 

    /**
     * Fully deletes a user's account
     * 
     * @param App\Models\User
     */
    public function deleteUser(User $user)
    {
        // Remove user from any associated vaults
        // Vault removal handles entry/asset/vault deletion, so we don't need to do anything else
        $vaults = $user->vaults;

        $vaults->each(function($vault, $key) use ($user) {
            $this->vaultService->removeUser($user, $vault);
        });

        // Delete the user
        $user->delete();
    }
    
}