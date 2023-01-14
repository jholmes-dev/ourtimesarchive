<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VaultService;
use App\Http\Requests\Vault\NewVaultRequest;
use App\Models\Vault;

class VaultController extends Controller
{

    /**
     * The vault service class
     * 
     * @var App\Services\VaultService
     */
    private $vaultService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(VaultService $vaultService)
    {
        $this->middleware('auth');
        $this->vaultService = $vaultService;
    }

    /**
     * Show all vaults
     * 
     */
    public function showAll(Request $request)
    {
        return view('vault.show-all', [ 'vaults' => $request->user()->vaults ]);
    }

    /**
     * Show the vault creation page
     * 
     */
    public function create()
    {
        return view('vault.create');
    }

    /**
     * Store a created vault
     * 
     */
    public function store(NewVaultRequest $request)
    {
        $response = $this->vaultService->createVault($request);
        
        return redirect()->route('vault.all')->with('success', 'Vault created!');
    }

    /**
     * Delete a vault
     * 
     */
    public function delete()
    {}

    /**
     * View for single vault
     * 
     * @param Integer $id : The vault ID we're accessing
     */
    public function view(Request $request, $id)
    {
        $vault = Vault::findOrFail($id);

        if ($request->user()->cannot('access', $vault)) {
            abort(403);
        }

        return view('vault.view', [ 
            'vault' => $vault
        ]);
    }

}
