<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LinksCollection;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $links = Link::where('user_id', auth()->user()->id)->get();
            return response()->json(new LinksCollection($links), 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:20',
            'url' => 'required|active_url',
        ]);

        try {
            $link = new Link;

            $link->user_id = auth()->user()->id;
            $link->name = $request->input('name');
            $link->url = $request->input('url');
            $link->image = '/link-placeholder.png';

            $link->save();

            return response()->json('NEW LINK CREATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Link $link)
    {
        $request->validate([
            'name' => 'required|max:18',
            'url' => 'required',
        ]);

        try {
            $link->name = $request->input('name');
            $link->url = $request->input('url');
            $link->save();

            return response()->json('LINK DETAILS UPDATED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link)
    {
        try {
            if (
                !is_null($link->image)
                && file_exists(public_path() . $link->image
                && $link->image != '/user-placeholder.png'
                && $link->image != '/link-placeholder.png'
            )) {
                unlink(public_path() . $link->image);
            }
            $link->delete();

            return response()->json('LINK DETAILS DELETEED', 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
