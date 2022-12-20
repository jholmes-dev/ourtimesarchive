<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VaultService;
use App\Http\Requests\Vault\NewVaultRequest;

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
        $validated = $request->validated();
        return back()->with('status', $validated['vault_name']);
    }

    /**
     * Delete a vault
     * 
     */
    public function delete()
    {}

}
