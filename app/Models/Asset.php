<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Asset extends Model
{
    use HasFactory;

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
        return Storage::url($this->path);
    }

}
