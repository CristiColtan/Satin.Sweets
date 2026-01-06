<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'price' => $this->price,
            'badge' => $this->badge,
            'discounted_price' => $this->discounted_price,
            'published' => $this->published,
            'additional_info' => $this->additional_info,
            'images' => $this->media->map(function ($media) {
                return [
                    'id' => $media->id,
                    'url' => $media->url,
                    'alt_text' => $media->alt_text,
                ];
            }),
            'parent_categories' => $this->categories
                ->map(fn($category) => $category->allParents()->map(fn($parent) => [
                    'id' => $parent->id,
                    'name' => $parent->name,
                ])
                )
                ->flatten(1)        // aplatizeaza array-ul de array-uri
                ->unique('id')      // elimina duplicatele
                ->values(),         // reindex
            'top_parent_categories' => $this->categories
                ->map(fn($category) => $category->topParent())
                ->unique('id')
                ->map(fn($parent) => [
                    'id' => $parent->id,
                    'name' => $parent->name,
                ])
                ->values(),
            'categories' => $this->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
