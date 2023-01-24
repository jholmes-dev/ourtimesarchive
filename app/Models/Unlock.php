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
     * Checks if all users have authorized the unlock
     * 
     * @return Boolean
     */
    public function isAuthorized()
    {
        //
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
     * Sets a user's unlock authorization
     * 
     * @param App\Models\User
     */
    public function setAuthorization(User $user)
    {
        //
    }

    /**
     * Accepts a collection of entries and stores them
     * 
     * @param Collection[App\Models\Entry]
     */
    public function setEntries($entries)
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
