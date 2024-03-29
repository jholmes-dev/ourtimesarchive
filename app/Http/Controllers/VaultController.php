<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VaultService;
use App\Http\Requests\Vault\NewVaultRequest;
use App\Http\Requests\Vault\UpdatePhotoRequest;
use App\Http\Requests\Vault\LeaveVaultRequest;
use App\Http\Requests\Vault\GenerateUnlockRequest;
use App\Models\Vault;
use Illuminate\Support\Facades\Storage;

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
     * Remove a user from a vault
     * Removes user, and all associated entries & assets
     * 
     * @param App\Http\Requests\Vault\LeaveVaultRequest $request : The authorized and validated request
     * @param Integer $id : The vault id we're modifying
     */
    public function leave(LeaveVaultRequest $request, $id)
    {
        $vault = Vault::findOrFail($id);
        $this->vaultService->removeUser($request->user(), $vault);
        return redirect()->route('vault.all')->with([ 'success' => 'You have left the vault' ]);
    }

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

    /** 
     * Retrieve a vault's vault photo
     * 
     */
    public function getPhoto(Request $request, $id)
    {
        $vault = Vault::findOrFail($id);

        if ($request->user()->cannot('access', $vault)) {
            abort(403);
        }

        if (!Storage::exists($vault->vault_photo)) {
            abort(404);
        }

        return response()->file(Storage::path($vault->vault_photo));
    }

    /**
     * Update a vault's Vault Photo
     * 
     * @param App\Http\Requests\Vault\UpdatePhotoRequest $request : The authorized and verified request
     * @param Integer $id : The vault ID that is being modified
     */
    public function updatePhoto(UpdatePhotoRequest $request, $id)
    {
        $vault = Vault::findOrFail($id);
        $this->vaultService->updateVaultPhoto($request, $vault);
        return back()->with([ 'success' => 'Vault image has been updated!']);
    }

    /**
     * Generates an unlock for the given vault
     * 
     * @param App\Http\Requests\Vault\GenerateUnlockRequest
     * @param Integer $id : The vault ID
     */
    public function generateLocalUnlock(GenerateUnlockRequest $request, $id)
    {
        $vault = Vault::findOrFail($id);
        $unlockRes = $vault->generateUnlock($request->user()->id);

        if ($unlockRes['status'] != 200) return back()->with('error', $unlockRes['message']);

        return redirect()->route('unlock.route', [
            'vid' => $vault->id, 
            'uid' => $unlockRes['data']->id
        ]);
    }

}
