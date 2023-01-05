<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EntryController extends Controller
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
     * Show view for entry creation
     * 
     */
    public function create()
    {
        return view('entry.create');
    }

    /**
     * View for storing an entry in the database
     * 
     */
    public function store(Request $request)
    {
        return back()->with([]);
    }

}
