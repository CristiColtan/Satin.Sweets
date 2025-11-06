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
        //        $reviews = $this->reviews;
        //        $average = round($this->reviews->avg('rating'), 1);
        //        $total = $this->reviews->count();
        //
        //        $breakdown = collect(range(1, 5))->map(function ($stars) use ($reviews) {
        //            return [
        //                'stars' => $stars,
        //                'count' => $reviews->where('rating', $stars)->count(),
        //            ];
        //        })->sortByDesc('stars')->values()->all();

        //not needed anymore

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
            'categories' => $this->categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
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
            'price' => $this->price,
            'discounted_price' => $this->discounted_price,
            'additional_info' => $this->additional_info,
            'badge' => $this->badge,
            'published' => (bool)$this->published,
//            'average_rating' => $average,
//            'total_reviews' => $total,
//            'rating_breakdown' => $breakdown,
//            'reviews' => ReviewResource::collection(
//                $this->whenLoaded('reviews')
//            ),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
