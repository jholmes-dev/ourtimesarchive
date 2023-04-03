<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vault;
use App\Models\Unlock;
use App\Models\UnlockAuthorization;

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
        return $this->entries()->where('unlock_id', NULL)->get();
    }

    /**
     * Generates a new unlock for the vault, or returns an existing unlock if it already exists
     * 
     * @param Integer $user_id : The requesting user's ID
     * @return Array : Array containing status, message, and data
     */
    public function generateUnlock($user_id)
    {  

        // Return existing unlock
        if ($this->unlocks->count() > 0) {

            $unlock = $this->unlocks->first();
            
        // Return error if no entries available to unlock
        } else if ($this->lockedEntries()->count() == 0) {

            return [
                'status' => '404',
                'message' => 'There are no entries in this vault to unlock'
            ];

        // Create a new unlock if not caught by above statements
        } else {

            $unlock = Unlock::create([
                'current_entry' => 0,
                'user_id' => $user_id,
                'vault_id' => $this->id
            ]);
            $unlock->generateUserAuths();

        }
        
        return [
            'status' => '200',
            'message' => 'Success',
            'data' => $unlock
        ];
    }

}
