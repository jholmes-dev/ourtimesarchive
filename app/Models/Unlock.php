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
     * Has many relationship for : Entries
     * 
     */
    public function entries()
    {
        return $this->hasMany(Entry::class);
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

        $uAuths = $this->unlockAuthorizations;
        for ($i = 0; $i < $uAuths->count(); $i++)
        {
            if ($uAuths[$i]->authorized_at == NULL) {
                return false;
            }
        }

        return true;
    }

    /**
     * Checks if the unlock is fully authorized, then runs needed commands if so
     * This should be called each time someone verifies a UAuth
     * 
     */
    public function checkForFullAuthorization()
    {
        if (!$this->isAuthorized()) return;

        // Associate all entries that haven't been unlocked yet to this unlock.
        $entries = $this->vault->entries()->where('unlock_id', NULL)->get();
        for ($i = 0; $i < $entries->count(); $i++)
        {
            $entries[$i]->unlock()->associate($this);
            $entries[$i]->save();
        }

    }

    /**
     * Creates an array of entries with data that is front-end friendly
     * 
     * @return Array
     */
    function getReturnableEntries()
    {
        return $this->entries->map(function($entry, $key) {
            $entry->location = unserialize($entry->location);
            $entry['author'] = $entry->user->name;
            $entry['images'] = $entry->assets->map(function($asset, $key) {
                return $asset->getUrl();
            })->toArray();
            return $entry;
        })->toArray();
    }

}
