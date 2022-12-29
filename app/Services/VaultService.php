<?php

namespace App\Services;

use App\Models\Vault;
use App\Models\Invite;
use App\Http\Requests\Vault\NewVaultRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserInvite;

class VaultService 
{
    
    /**
     * Constructs a new service
     */
    public function __construct() 
    {
        //
    } 

    /**
     * Creates and stores a new vault given the request
     * 
     * @param App\Http\Requests\Vault\NewVaultRequest $request
     */
    public function createVault(NewVaultRequest $request)
    {
        $input = $request->validated();

        // Create vault
        $vault = Vault::create([
            'name' => $input['vault_name']
        ]);

        // Attach to requesting user
        $request->user()->vaults()->attach($vault);

        // Create invitations and send them
        for ($i = 0; $i < count($input['invites']); $i++)
        {
            if ($input['invites'][$i] == null) {
                continue;
            }

            $invite = Invite::create([
                'expires' => date('Y-m-d h:i:s', strtotime('today + 1 week')),
                'to' => $input['invites'][$i]
            ]);
            $invite->fromUser()->associate($request->user());
            $invite->vault()->associate($vault);
            $invite->save();

            Mail::to($invite->to)
                ->queue(new UserInvite($invite));

        }
    }
    
}