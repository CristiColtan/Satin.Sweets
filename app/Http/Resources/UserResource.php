<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = 'false';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'favorite_ids' => $this->whenLoaded('favorites', fn() => $this->favorites->pluck('id')),
            'favorites_count' => $this->whenCounted('favorites'),
        ];
    }

}
