<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LinksCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($link) {
            return [
                'id' => $link->id,
                'user_id' => $link->user_id,
                'name' => $link->name,
                'url' => $link->url,
                'image' => url('/') . $link->image,
            ];
        });
    }
}
