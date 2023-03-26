<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UnlockAuthorization;
use App\Http\Requests\UnlockAuthorization\UnlockAuthorizationVerificationRequest;

class UnlockAuthorizationController extends Controller
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
     * Verifies a user provided authorization
     *  
     */    
    public function verifyAuthorization(UnlockAuthorizationVerificationRequest $request)
    {
        $uAuth = UnlockAuthorization::findOrFail($request->input('uaid'));
        
        if ($uAuth->authorizeUnlock($request->input('password'))) {
            return response()->json([
                'status' => true,
                'message' => 'Authorization successful!'
            ]);
        } else {
            abort(403, 'Authentication failed. Check your password.');
        }

    }

}
