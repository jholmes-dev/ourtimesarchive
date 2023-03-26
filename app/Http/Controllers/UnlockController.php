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
     * Routes an unlock request to the proper step function below
     * 
     * @param Illuminate\Http\Request
     * @param String $vid : The associated vault's ULID
     * @param String $uid : The associated unlock's ULID
     */
    public function routeUnlock(Request $request, $vid, $uid)
    {
        $vault = Vault::findOrFail($vid);
        if ($request->user()->cannot('access', $vault)) abort(403);
        $unlock = Unlock::findOrFail($uid);

        if (!$unlock->isAuthorized()) {
            return $this->authorizeUnlock($request, $vault, $unlock);
        } else {
            return $this->viewUnlock($request, $vault, $unlock);
        }
    }

    /**
     * Returns the authentication page for a vault unlock
     * 
     * @param Illuminate\Http\Request
     * @param App\Models\Vault
     * @param App\Models\Unlock
     */
    private function authorizeUnlock(Request $request, $vault, $unlock)
    {
        return view('unlock.authorize', [
            'unlock' => $unlock
        ]);
    }

    /**
     * Returns a specific unlock page
     * 
     * @param Illuminate\Http\Request
     * @param App\Models\Vault
     * @param App\Models\Unlock
     */
    private function viewUnlock(Request $request, $vault, $unlock)
    {
        return view('unlock.view');
    }
    
}
