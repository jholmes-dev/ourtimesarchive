<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UnlockAuthorization extends Model
{
    use HasFactory;

    /**
     * The fields that are hidden from mass assignment
     * 
     * @var Array
     */
    protected $guarded = [];

    /**
     * Belongs to function for Unlock
     * 
     */
    public function unlock()
    {
        return $this->belongsTo(Unlock::class);
    }

    /**
     * Belongs to function for User
     * 
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Checks the provided password against the owning user to verify the unlock
     * 
     * @param String $password
     * @return Boolean
     */
    public function authorizeUnlock($password)
    {
        if (!Hash::check($password, $this->user->password)) return false;
        $this->authorized_at = now()->toDateTimeString();
        $this->save();
        return true;        
    }
}
