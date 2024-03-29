<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory, HasUlids;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];
    
    /**
     * Belongs to relationship : User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Belongs to relationship : Entry
     * 
     */
    public function entry()
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * Returns the public URL for the asset
     * 
     * @return String
     */
    public function getUrl()
    {
        return route('asset.view', $this->id);
    }

}
