<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InviteController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * View an invite
     * 
     */
    public function viewAll(Request $request)
    {
        return view('invite.show-all', [ 'invites' => $request->user()->receivedInvites() ]);
    }

    /**
     * Respond to an invite
     * 
     */
    public function respond()
    {
        //
    }

}
