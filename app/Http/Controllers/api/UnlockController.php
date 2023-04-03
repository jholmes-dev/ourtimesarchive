<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Unlock;
use App\Http\Requests\Unlock\GetUnlockEntriesRequest;

class UnlockController extends Controller
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
     * Retrieves and returns a JSON Object of entries related to the unlock
     * 
     */
    public function getUnlockEntries(GetUnlockEntriesRequest $request, $unlock_id)
    {
        $unlock = Unlock::findOrFail($unlock_id);
        
        return response()->json(
            $unlock->getReturnableEntries()
        );
    }
}
