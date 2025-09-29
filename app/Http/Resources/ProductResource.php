<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->mainImage()?->url,
            'images' => $this->media->map(fn($m) => [
                'id' => $m->id,
                'url' => $m->url,
                'alt_text' => $m->alt_text,
                'role' => $m->pivot->role,
            ]),
            'price' => $this->price,
            'published' => (bool)$this->published,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
