<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Entry\NewEntryRequest;
use App\Services\EntryService;

class EntryController extends Controller
{
    
    /**
     * Entry service variable
     * 
     * @var App\Services\EntryService
     */
    public $entryService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(EntryService $entryService)
    {
        $this->middleware('auth');
        $this->entryService = $entryService;
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
        $result = $this->entryService->createEntry($request);

        return back()->with(['input' => $validated]);
    }

}
