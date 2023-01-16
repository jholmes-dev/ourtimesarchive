<?php

namespace App\Services;

use App\Services\AssetService;
use App\Http\Requests\Entry\NewEntryRequest;
use App\Models\Vault;
use App\Models\Entry;

class EntryService 
{

    /**
     * Asset service variable
     * 
     * @var App\Services\AssetService
     */
    protected $assetService;

    /**
     * Constructs a new service
     */
    public function __construct(AssetService $assetService) 
    {
        $this->assetService = $assetService;
    } 

    /**
     * Handles all aspects of entry creation
     * 
     * @param App\Requests\Entry\NewEntryRequest $request : Pre-Authorized request
     * @return JSON
     */
    public function createEntry(NewEntryRequest $request)
    {   
        // Format data for entry creation
        $validated = $request->validated();
        $vault = Vault::findOrFail($validated['vault_id']);
        $locationDetails = [
            'raw_input' => $validated['entry_address'],
            'loc_details' => json_decode($validated['entry_location_details'])
        ];

        // Create a new entry
        $entry = Entry::create([
            'title' => $validated['entry_title'],
            'location' => serialize($locationDetails),
            'date' => $validated['entry_date'],
            'content' => $validated['entry_content'],
            'user_id' => $request->user()->id,
            'vault_id' => $vault->id
        ]);

        // Prep return data
        $returnData = [
            'status' => 200,
            'message' => 'Your entry was created successfully!'
        ];

        // Loop through images and pass them off to the AssetService for saving
        foreach ($validated['images'] as $image) 
        {
            $data = substr($image, strpos($image, ',') + 1);
            $asset = $this->assetService->createFromBase64($data, $request->user()->id, $entry->id, $vault->id);

            if ($asset === false) {
                $returnData['message'] = 'Your entry was created successfully, but some images failed to upload.';
            }
        }

        return $returnData;
    }

    /**
     * Deletes and entry and its related assets
     * 
     * @param App\Models\Entry
     */
    public function delete(Entry $entry)
    {
        // Loop through related assets
        $entry->assets->each(function($asset, $key) {
            $this->assetService->delete($asset);
        });

        // Delete entry
        $entry->delete();
    }
    
}