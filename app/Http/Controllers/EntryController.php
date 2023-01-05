<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Entry\NewEntryRequest;

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
    public function create(Request $request)
    {
        $vaults = $request->user()->vaults;
        return view('entry.create')->with([ 'vaults' => $vaults ]);
    }

    /**
     * View for storing an entry in the database
     * 
     */
    public function store(NewEntryRequest $request)
    {
        $validated = $request->validated();
        return back()->with(['input' => $validated]);
    }

}
