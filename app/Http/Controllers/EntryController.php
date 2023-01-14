<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vault;
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
     * @param $id : The optional vault ID for pre-selection
     */
    public function create(Request $request, $id = NULL)
    {
        $vaults = $request->user()->vaults;

        if ($vaults->isEmpty()) {
            return redirect()->route('vault.all')->with('status', 'You need to create or join a vault first.');
        }

        $selectedVault = ($id == NULL) ? $vaults[0] : Vault::findOrFail($id);
        if ($request->user()->cannot('access', $selectedVault)) {
            abort(403);
        }

        return view('entry.create')->with([ 
            'vaults' => $vaults,
            'selectedVault' => $selectedVault
        ]);
    }

    /**
     * View for storing an entry in the database
     * 
     */
    public function store(NewEntryRequest $request)
    {
        $result = $this->entryService->createEntry($request);
        return back()->with(['success' => $result['message']]);
    }

}
