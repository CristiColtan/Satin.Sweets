<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Product;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        $reviews = $product->reviews()->with(['user', 'reply'])->paginate(2);

        $allReviews = $product->reviews;
        $average = round($allReviews->avg('rating'), 1);
        $total = $allReviews->count();

        $breakdown = collect(range(1, 5))->map(function ($stars) use ($allReviews) {
            return [
                'stars' => $stars,
                'count' => $allReviews->where('rating', $stars)->count(),
            ];
        })->sortByDesc('stars')->values()->all();

        return ReviewResource::collection($reviews)->additional([
            'meta' => [
                'average_rating' => $average,
                'total_reviews' => $total,
                'rating_breakdown' => $breakdown,
            ],
        ]);
    }

    public function store(ReviewRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $review = new Review([
            'rating' => $request->rating,
            'text' => $request->text,
            'user_order_id' => $request->user_order_id,
            'user_email' => $request->user_email,
            'user_id' => auth()->id(),
        ]);

        $product->reviews()->save($review);

        return new ReviewResource($review->load('user'));
    }
}
