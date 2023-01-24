<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use App\Models\Unlock;
use Illuminate\Http\Request;
use App\Services\UnlockService;

class UnlockController extends Controller
{

    /**
     * The unlockService instance
     * 
     * @var App\Services\UnlockService
     */
    private $unlockService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UnlockService $unlockService)
    {
        $this->middleware('auth');
        $this->unlockService = $unlockService;
    }

    /**
     * Returns a specific unlock page
     * 
     * @param Illuminate\Http\Request
     * @param String $vid : The associated vault's ULID
     * @param String $uid : The associated unlock's ULID
     */
    public function view(Request $request, $vid, $uid)
    {
        $vault = Vault::findOrFail($vid);
        if ($request->user()->cannot('access', $vault)) abort(403);
        
        $unlock = Unlock::findOrFail($uid);

        return view('unlock.view');
    }
    
}
