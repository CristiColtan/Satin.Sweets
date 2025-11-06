<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'rating' => $this->rating,
            'text' => $this->text,
            'user_email' => $this->user_email,
            'user_order_id' => $this->user_order_id,
            'is_approved' => $this->is_approved,
            'is_buyer_verified' => $this->is_buyer_verified,
            'reply' => $this->whenLoaded('reply', fn() => new ReviewReplyResource($this->reply)),
            'author' => $this->whenLoaded('user', fn() => new UserResource($this->user)),
            'created_at' => $this->created_at->format('d M Y'),
        ];
    }
}
