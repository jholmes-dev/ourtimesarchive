<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasFactory;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];

    /**
     * Belongs to relationship for : Vault
     * 
     */
    public function vault() 
    {
        return $this->belongsTo(Vault::class);
    }

    /**
     * Belongs to relationship for : User
     * The user who sent the invite
     * 
     */
    public function fromUser() 
    {
        return $this->belongsTo(User::class);
    }

}
