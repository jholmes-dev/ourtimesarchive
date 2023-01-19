<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Http\Requests\User\ChangePasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Services\UserService;

class UserController extends Controller
{

    use AuthenticatesUsers;

    /**
     * User service
     * 
     * @var App\Services\UserService
     */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
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

    /**
     * Deletes a user's account
     * 
     */
    public function deleteAccount(Request $request)
    {
        $this->userService->deleteUser($request->user());
        return $this->logout($request);
    }

}
