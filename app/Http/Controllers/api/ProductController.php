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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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
    }


    /**
     * Display the specified resource.
     */
    public function show($product)
    {
        $product = Product::where('id', $product)->orWhere('slug', $product)->firstOrFail();
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        unset($data['image'], $data['images']);

        $product->update($data);

        if ($request->hasFile('images')) {
            // 1. Ștergem toate imaginile vechi
            foreach ($product->media as $oldMedia) {
                Storage::delete(
                    str_replace('/storage/', 'public/', parse_url($oldMedia->url, PHP_URL_PATH))
                );
                $product->media()->detach($oldMedia->id);
                $oldMedia->delete();
            }

            // 2. Salvăm noile imagini
            foreach ($request->file('images') as $image) {
                $relativePath = $image->store('products', 'public');

                $media = Media::create([
                    'url' => URL::to(Storage::url($relativePath)),
                    'alt_text' => $product->title,
                ]);

                $product->media()->attach($media->id, ['role' => 'gallery']);
            }
        }
        return new ProductResource($product->load('media'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        unset($data['image'], $data['images']);

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

        return new ProductResource($product->load('media'));
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
