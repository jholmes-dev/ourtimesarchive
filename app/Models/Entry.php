<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory, HasUlids;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];

    /**
     * Attribute casts
     * 
     * @var Array
     */
    protected $casts [
        'date' => 'date'
    ];

    /**
     * Belongs to relationship : User
     * 
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to relationship : Vault
     * 
     */
    public function vault()
    {
        return $this->belongsTo(Vault::class);
    }

    /**
     * Has many relationship : Asset
     * 
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

}
