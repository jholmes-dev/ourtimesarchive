<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vault;
use App\Models\Unlock;

class Vault extends Model
{
    use HasFactory;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];
    
    /**
     * Has many relationship : Users
     * 
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Has many relationship : Entry
     * 
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * Has manty relationship : Invite
     * 
     */
    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

    /**
     * Has many relationship for : Unlock
     * 
     */
    public function unlocks() 
    {
        return $this->hasMany(Unlock::class);
    }

    /**
     * Returns a collection of locked entries related to the vault
     * 
     * @param Collection[App\Models\Entry]
     */
    public function lockedEntries()
    {
        return $this->entries()->where('unlocked', false)->get();
    }

    /**
     * Initializes and returns an authorization array related to this vault for an Unlock
     * 
     * @return Array
     */
    public function generateAuthArray()
    {
        $authArray = [];

        $this->users->each(function($user, $key) use (&$authArray) {
            $authArray[$user->id] = false;
        });

        return $authArray;
    }

    /**
     * Generates an unlock for the vault, and attaches the given user
     * 
     * @param Integer $user_id : The requesting user's ID
     * @return Array : Array containing status, message, and data
     */
    public function generateUnlock($user_id)
    {  
        $entries = $this->lockedEntries();
        if ($entries->count() == 0) {
            return [
                'status' => '404',
                'message' => 'There are no entries in this vault to unlock'
            ];
        }

        // Return any existing unlocks
        $unlocks = $this->unlocks;
        if ($unlocks->count() > 0) {
            return [
                'status' => '200',
                'message' => 'There is already an active unlock for this vault',
                'data' => $unlocks->first()
            ];
        }

        $unlock = Unlock::create([
            'users' => serialize($this->generateAuthArray()),
            'entry_ids' => serialize($entries->modelKeys()),
            'current_entry' => 0,
            'user_id' => $user_id,
            'vault_id' => $this->id
        ]);

        return [
            'status' => '200',
            'message' => 'Success',
            'data' => $unlock
        ];
    }

}
