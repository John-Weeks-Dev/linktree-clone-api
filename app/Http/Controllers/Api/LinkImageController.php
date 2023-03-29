<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Services\FileService;
use Illuminate\Http\Request;

class LinkImageController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg'
        ]);

        try {
            $link = Link::where('id', $request->input('id'))
                ->where('user_id', auth()->user()->id)
                ->first();
            $link = (new FileService)->updateImage($link, $request);
            $link->save();

            return response()->json('Link IMAGE UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
