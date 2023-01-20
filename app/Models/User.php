<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Invite;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Has many relationship : Vault
     * 
     */
    public function vaults()
    {
        return $this->belongsToMany(Vault::class);
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
     * Has many relationship : Asset
     * 
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }

    /**
     * Has many relationship : Invite
     * The invites the user has sent 
     *
     */
    public function invites()
    {
        return $this->hasMany(Invite::class, 'from_user_id');
    }
    
    /**
     * Returns invites that match the user's email address
     * 
     */
    public function pendingInvites()
    {
        return Invite::where('to', $this->email)
            ->where('rejected', false)
            ->orderBy('created_at')
            ->get()
            ->reject(function($invite) {
                return $invite->isExpired();
            });
    }

    /**
     * Updates the user's name
     * 
     * @param String : The new name to set
     */
    public function updateName($name)
    {
        $this->name = $name;
        $this->save();
    }

}
