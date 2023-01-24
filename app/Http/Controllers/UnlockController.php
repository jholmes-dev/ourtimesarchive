<?php

namespace App\Http\Controllers;

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
     * @param String $vid : The associated vault's ULID
     * @param String $uid : The associated unlock's ULID
     */
    public function view($vid, $uid)
    {
        return view('unlock.view');
    }
    
}
