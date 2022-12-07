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

}
