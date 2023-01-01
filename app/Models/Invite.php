<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \DateTime;

class Invite extends Model
{
    use HasFactory, HasUlids;

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

    /**
     * Returns a string with remaining time on the invite
     *
     * @return String : String the represents time until the expiration date
     */
    public function expiresIn()
    {
        $dateDiff = date_diff(new DateTime($this->expires), new DateTime());
        $outputString;
        $outputNumber;

        // Find the specifity
        if ($dateDiff->d >= 1) {
            $outputString = $dateDiff->d . ' day';
            $outputNumber = $dateDiff->d;
        } elseif ($dateDiff->h >= 1) {
            $outputString = $dateDiff->h . ' hour';
            $outputNumber = $dateDiff->h;
        } elseif ($dateDiff->i >= 1) {
            $outputString = $dateDiff->i . ' minute';
            $outputNumber = $dateDiff->i;
        } else {
            $outputString = $dateDiff->s . ' second';
            $outputNumber = $dateDiff->s;
        }

        if ($outputNumber > 1) {
            $outputString .= 's';
        }

        return $outputString;
        
    }

    /**
     * Checks if the invite is expired
     * 
     * @return Boolean
     */
    public function isExpired()
    {
        return strtotime('now') >= strtotime($this->expires);
    }

}
