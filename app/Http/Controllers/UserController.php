<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
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
     * Returns view for the account overview page
     * 
     */
    public function viewAccount(Request $request)
    {
        return view('user.account', [ 'user' => $request->user() ]);
    }

    /**
     * Changes a user's password
     * 
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $input = $request->validated();

        $request->user()->forceFill([
            'password' => Hash::make($input['new_password']),
            'remember_token' => Str::random(60),
        ])->save();

        return back()->with('success', 'Your password has been updated');
    }

}
