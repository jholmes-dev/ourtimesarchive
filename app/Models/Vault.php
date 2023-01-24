<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

}
