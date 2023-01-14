<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use App\Services\InviteService;

class InviteController extends Controller
{

    /**
     * The inviteService instance
     * 
     * @var App\Services\InviteService
     */
    private $inviteService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(InviteService $inviteService)
    {
        $this->middleware('auth');
        $this->inviteService = $inviteService;
    }

    /**
     * View all invite
     * 
     */
    public function viewAll(Request $request)
    {
        return view('invite.show-all', [ 'invites' => $request->user()->receivedInvites() ]);
    }

    /**
     * Accepts an invite
     * 
     * @param Illuminate\Http\Request $request
     * @param String $id : The invite ID
     */
    public function accept(Request $request, $id)
    {
        // Find the invite
        $invite = Invite::findOrFail($id);

        // Accept the invite
        $res = $this->inviteService->acceptInvite($request, $invite);

        // Check the status and return
        if ($res['status'] !== 200) {
            return back()->with('error', $res['message']);
        }
        return redirect()->route('vault.all')->with('success', $res['message']);
    }

    /**
     * Rejects an invite
     * 
     * @param Illuminate\Http\Request $request
     * @param String $id : The invite ID
     */
    public function reject(Request $request, $id)
    {
        // Find the invite
        $invite = Invite::findOrFail($id);

        // Accept the invite
        $res = $this->inviteService->rejectInvite($request, $invite);

        // Check the status and return
        if ($res['status'] !== 200) {
            return back()->with('error', $res['message']);
        }
        return back()->with('status', $res['message']);
    }

}
