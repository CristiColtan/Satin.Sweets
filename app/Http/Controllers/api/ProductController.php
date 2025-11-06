<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Media;
use App\Models\Product;
use Exception;
use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Meilisearch\Client;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    //index v1
    /*public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Product::query()->where('title', 'like', "%$search%")->orderBy($sortField, $sortDirection)->paginate($perPage);
        //Product::query()
        //  ->name('test')
        //   ->get();

        return ProductListResource::collection($query);
    }*/
    public function index()
    {
        $perPage = (int)request('per_page', 10);
        $page = (int)request('page', 1);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        $categoryId = request('category_id');

        if ($search === '') {
            $query = Product::query()
                ->with(['media', 'categories'])
                ->orderBy($sortField, $sortDirection);

            if ($categoryId) {
                $query->whereHas('categories', function ($q) use ($categoryId) {
                    $q->where('categories.id', $categoryId);
                });
            }

            return $query->paginate($perPage);
        }

        $client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );
        $index = $client->index('products');

        $sortable = $index->getSortableAttributes();
        if (!in_array($sortField, $sortable)) {
            $newSortables = array_unique(array_merge($sortable, [$sortField]));
            $index->updateSortableAttributes($newSortables);
        }

        $offset = ($page - 1) * $perPage;

        $result = $index->search($search, [
            'limit' => $perPage,
            'offset' => $offset,
            'sort' => ["{$sortField}:{$sortDirection}"],
            'attributesToHighlight' => ['title', 'description'],
            'highlightPreTag' => '<mark>',
            'highlightPostTag' => '</mark>',
        ]);

        $hits = $result->getHits();
        $ids = collect($hits)->pluck('id');
        $total = $result->getEstimatedTotalHits();

        $products = Product::whereIn('id', $ids)
            ->with('media')
            ->with('categories')
            ->get()
            ->keyBy('id');

        $items = collect($hits)->map(function ($hit) use ($products) {
            $product = $products->get($hit['id']);
            if (!$product) {
                return null;
            }

            $resource = (new ProductListResource($product))->toArray(request());
            $resource['_formatted'] = $hit['_formatted'] ?? [];

            return $resource;
        })->filter();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $page,
            ['path' => url()->current()]
        );
    }

    public function show($product)
    {
        $product = Product::where('id', $product)->orWhere('slug', $product)->firstOrFail();
        return new ProductResource($product);
    }

    public function showSlug($slug)
    {
        $product = Product::with([
            'categories.parent.parent.parent',
            'media',
            'reviews.user',
            'reviews.reply.user',
        ])->where('slug', $slug)->firstOrFail();
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        unset($data['image'], $data['images'], $data['remove_image_ids'], $data['categories']);

        DB::transaction(function () use ($request, $data, $product) {
            if ($request->has('additional_info')) {
                $json = $request->input('additional_info');
                if (is_string($json)) {
                    $data['additional_info'] = json_decode($json, true);
                } elseif (is_array($json)) {
                    $data['additional_info'] = $json;
                }
            }

            $product->update($data);

            $categories = (array)$request->input('categories', []);
            if (!empty($categories)) {
                $product->categories()->sync($categories);
            }

            $removeIds = (array)$request->input('remove_image_ids', []);

            if (!empty($removeIds)) {
                $toRemove = $product->media()->whereIn('media.id', $removeIds)->get();

                foreach ($toRemove as $media) {
                    $publicPath = $this->publicPathFromUrl($media->url);
                    if ($publicPath && Storage::exists($publicPath)) {
                        Storage::disk('public')->delete($publicPath);
                    }

                    $product->media()->detach($media->id);
                    $media->delete();
                }
            }
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $relativePath = $image->store('products', 'public');

                    $media = Media::create([
                        'url' => URL::to(Storage::url($relativePath)),
                        'alt_text' => $product->title,
                    ]);

                    $product->media()->attach($media->id, ['role' => 'gallery']);
                }
            }
        });
        return new ProductResource($product->load('media', 'categories'));
    }

    private function publicPathFromUrl(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH) ?? '';
        return ltrim(str_replace('/storage/', '', $path), '/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        unset($data['image'], $data['images'], $data['remove_image_ids'], $data['categories']);

        if (Product::where('title', $data['title'])->exists()) {
            return response()->json([
                'message' => 'Există deja un produs cu acest titlu.',
            ], 422);
        }

        if ($request->has('discounted_price')) {
            if ($request->filled('discounted_price')) {
                $data['discounted_price'] = $request->input('discounted_price');
            } else {
                $data['discounted_price'] = null;
            }
        }

        if ($request->has('additional_info')) {
            $json = $request->input('additional_info');
            if (is_string($json)) {
                $data['additional_info'] = json_decode($json, true);
            } else {
                if (is_array($json)) {
                    $data['additional_info'] = $json;
                }
            }
        }

        $product = DB::transaction(function () use ($request, $data) {
            $product = Product::create($data);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $relativePath = $image->store('products', 'public');
                    $media = Media::create([
                        'url' => URL::to(Storage::url($relativePath)),
                        'alt_text' => $product->title,
                    ]);

                    $product->media()->attach($media->id, ['role' => 'gallery']);
                }
            }

            $categories = (array)$request->input('categories', []);

            if (!empty($categories)) {
                $product->categories()->sync($categories);
            }

            return $product;
        });

        return new ProductResource($product->load('media', 'categories'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

    private function saveImage(UploadedFile $image)
    {
        $path = 'images/' . Str::random();
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path, 0755, true);
        }
        if (!Storage::putFileAs('public/' . $path, $image, $image->getClientFilename())) {
            throw new Exception("Failed to save file \"{$image->getClientFilename()}\"");
        }

        return $path . '/' . $image->getClientFilename();
    }
}
