<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Invite;

class InviteService 
{
    
    /**
     * Constructs a new service
     * 
     */
    public function __construct() 
    {
        //
    } 

    /**
     * Accepts an invite
     * 
     * @return Array containing response code and message
     */
    public function acceptInvite(Request $request, Invite $invite)
    {
        // Authorize the requesting user
        if ($request->user()->cannot('respond', $invite)) {
            return Array(
                'status' => 403,
                'message' => 'Unauthorized'
            );
        }

        // Ensure the invite is not expired
        if ($invite->isExpired()) {
            return Array(
                'status' => 400,
                'message' => 'The invitation has expired'
            );
        }

        // Attach user to the vault
        $request->user()->vaults()->attach($invite->vault);

        // Delete the invite
        $invite->delete();

        // Return success
        return Array(
            'status' => 200,
            'message' => 'The invitation has been accepted'
        );
    }

    /**
     * Rejects an invite
     * 
     */
    public function rejectInvite(Request $request, Invite $invite)
    {
        // Authorize the requesting user
        if ($request->user()->cannot('respond', $invite)) {
            return Array(
                'status' => 403,
                'message' => 'Unauthorized'
            );
        }

        // Mark the invite as rejected
        $invite->rejected = true;
        $invite->save();

        // Return success
        return Array(
            'status' => 200,
            'message' => 'The invitation has been rejected'
        );
    }
    
}