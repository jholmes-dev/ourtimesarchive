<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
     * 
     */
    public function invites()
    {
        return $this->hasMany(Invite::class);
    }

}
