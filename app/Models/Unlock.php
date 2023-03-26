<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Unlock extends Model
{
    use HasFactory, HasUlids;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];

    /**
     * The default attribute values
     * 
     * @var Array
     */
    protected $attributes = [
        'current_entry' => 0
    ];

    /**
     * Belongs to relationship for : Vault
     * 
     */
    public function vault() 
    {
        return $this->belongsTo(Vault::class);
    }

    /**
     * Has many relationship for : UnlockAuthorization
     * 
     */
    public function unlockAuthorizations()
    {
        return $this->hasMany(UnlockAuthorization::class);
    }

    /**
     * Creates a user authorization for each user associated with the unlock's vault
     * 
     * @param ULID
     */
    public function generateUserAuths()
    {
        if ($this->haveAuthsBeenGenerated()) return;

        $this->vault->users->each(function($user, $key) 
        {
            UnlockAuthorization::create([
                'user_id' => $user->id,
                'unlock_id' => $this->id
            ]);
        });
    }

    /**
     * Checks user authorizations have been generated yet
     * 
     * @return Boolean
     */
    public function haveAuthsBeenGenerated()
    {
        return ($this->unlockAuthorizations->count() == 0) ? false : true;
    } 

    /**
     * Checks if all users have authorized the unlock
     * 
     * @return Boolean
     */
    public function isAuthorized()
    {
        if (!$this->haveAuthsBeenGenerated()) return false;

        for ($i = 0; $i < $this->unlockAuthorizations->count(); $i++)
        {
            if ($this->unlockAuthorizations[$i]->authorized_at == NULL) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if a specific user has authorized the unlock
     * 
     * @param App\Models\User
     * @return Boolean
     */
    public function hasAuthorized(User $user)
    {
        //
    }

    /**
     * Returns collection of entries from database
     * 
     * @return Collection[App\Models\Entry]
     */
    public function getEntries()
    {
        //
    }

    /**
     * Returns a single entry given an index
     * 
     * @param Integer
     * @return App\Models\Entry
     */
    public function getEntry()
    {
        //
    }

    /**
     * Gets the total number of entries in the unlock
     * 
     * @return Integer
     */
    public function totalEntries()
    {
        //
    }

    /**
     * Returns the next unread entry
     *  
     * @return App\Models\Entry
     */
    public function nextEntry()
    {
        //
    }
}
