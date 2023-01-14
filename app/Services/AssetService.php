<?php

namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class AssetService 
{
    
    /**
     * Constructs a new service
     */
    public function __construct() 
    {
        //
    } 

    /**
     * Creates and stores an asset from a Base64 encoded string
     * 
     * @param String $data : Base64 encoded image string
     * @param Integer $user_id : User ID
     * @param String $entry_id : Entry UUID
     * @return App\Models\Asset
     */
    public function createFromBase64($data, $user_id, $entry_id) 
    {
        $imageData = base64_decode($data);

        $tempFile = tmpfile();
        $tempFilePath = stream_get_meta_data($tempFile)['uri'];

        // Save file data in file
        file_put_contents($tempFilePath, $imageData);

        // Store image and destory our local copy
        $imagePath = Storage::putFile('images', new File($tempFilePath));
        fclose($tempFile);

        // Create and return the Asset
        $asset = Asset::create([
            'path' => $imagePath,
            'type' => 1,
            'user_id' => $user_id,
            'entry_id' => $entry_id
        ]);

        return $asset;

    }
    
}