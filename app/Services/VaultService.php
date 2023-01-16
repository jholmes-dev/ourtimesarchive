<?php

namespace App\Services;

use App\Models\Vault;
use App\Models\Invite;
use App\Http\Requests\Vault\NewVaultRequest;
use App\Http\Requests\Vault\UpdatePhotoRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Mail\UserInvite;
use \Imagick;

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

        // Upload and store vault photo if included
        if ($input['vault_photo'] != NULL)
        {
            $this->saveVaultPhoto($vault, $request->file('vault_photo'));
        }

    }

    /**
     * Updates an existing vault's photo
     * 
     */
    public function updateVaultPhoto(UpdatePhotoRequest $request, Vault $vault)
    {
        $this->deleteVaultPhoto($vault);
        $this->saveVaultPhoto($vault, $request->file('vault_photo'));
    }

    /**
     * Handles vault photo creation
     * 
     * @param App\Models\Vault $vault : The vault to be modified
     * @param $image : The temp image to be cropped and saved
     */
    public function saveVaultPhoto(Vault $vault, $image)
    {
        $cropResponse = $this->cropVaultPhoto($image->path());

        if ($cropResponse == false) {
            return false;
        }

        $filePath = $image->store('images/' . $vault->id);
        $vault->vault_photo = $filePath;
        $vault->save();
        
        return true;
    }

    /**
     * Crops vault photo for storage
     * 
     * @param $image : The image to be cropped and returned
     * @return Boolean : If the image could be cropped and saved successfully
     */
    public function cropVaultPhoto($imagePath)
    {
        try {
            $postImage = new Imagick($imagePath);
            $postImage->scaleImage(800, 0);
            $postImage->writeImage();
            return true;
        } catch (\Exception $e) {
            Log::error($e);
            return false;
        }
    }

    /**
     * Deletes a vault's Vault Photo
     * 
     * @param App\Models\Vault $vault : The vault being modified
     */
    public function deleteVaultPhoto($vault)
    {
        Storage::delete($vault->vault_photo);
        $vault->vault_photo = null;
        $vault->save();
    }
    
}