<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VaultController extends Controller
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
     * Show the vault creation page
     * 
     */
    public function create()
    {}

    /**
     * Store a created vault
     * 
     */
    public function store()
    {}

    /**
     * Delete a vault
     * 
     */
    public function delete()
    {}

}
