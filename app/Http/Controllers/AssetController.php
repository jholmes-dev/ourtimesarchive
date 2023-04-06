<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
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
     * Retrieve an asset
     * 
     */
    public function view(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        if ($request->user()->cannot('view', $asset))   abort(403);
        if (!Storage::exists($asset->path))             abort(404);

        return response()->file(Storage::path($asset->path));
    }

}
