<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddonRequest;
use App\Http\Resources\AddonListResource;
use App\Http\Resources\AddonResource;
use App\Models\Addon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Meilisearch\Client;
use Meilisearch\Exceptions\ApiException;

class AddonController extends Controller
{
    public function index()
    {
        $perPage = (int)request('per_page', 10);
        $page = (int)request('page', 1);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');
        $type = request('type');

        if ($search === '') {
            $query = Addon::query()
                ->with('categories')
                ->when($type, fn($q) => $q->where('type', $type))
                ->orderBy($sortField, $sortDirection);

            return $query->paginate($perPage);
        }

        $client = new Client(
            config('scout.meilisearch.host'),
            config('scout.meilisearch.key')
        );

        try {
            $index = $client->getIndex('addons');
        } catch (ApiException $e) {
            $index = $client->createIndex('addons');
        }

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
            'attributesToHighlight' => ['name', 'description'],
            'filter' => 'type = "' . addslashes($type) . '"',
            'highlightPreTag' => '<mark>',
            'highlightPostTag' => '</mark>',
        ]);

        $hits = $result->getHits();
        $ids = collect($hits)->pluck('id');
        $total = $result->getEstimatedTotalHits();

        $addons = Addon::whereIn('id', $ids)
            ->with('categories')
            ->get()
            ->keyBy('id');

        $items = collect($hits)->map(function ($hit) use ($addons) {
            $addon = $addons->get($hit['id']);
            if (!$addon) {
                return null;
            }

            $resource = (new AddonListResource($addon))->toArray(request());
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

    public function show($addon)
    {
        $addon = Addon::where('id', $addon)->firstOrFail();
        return new AddonResource($addon);
    }

    public function store(AddonRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        unset($data['image'], $data['images'], $data['categories']);

        $addon = DB::transaction(function () use ($request, $data) {
            $addon = Addon::create($data);

            if ($request->hasFile('images')) {
                $relativePath = $request->file('images')[0]->store('addons', 'public');
                $fullUrl = URL::to(Storage::url($relativePath));

                $addon->update([
                    'image' => $fullUrl,
                ]);
            }

            $categories = (array)$request->input('categories', []);
            if (!empty($categories)) {
                $addon->categories()->sync($categories);
            }

            return $addon;
        });

        return new AddonResource($addon->load('categories'));
    }

    public function update(AddonRequest $request, Addon $addon)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;
        unset($data['image'], $data['images'], $data['categories']);

        DB::transaction(function () use ($request, $data, $addon) {
            $addon->update($data);

            $categories = (array)$request->input('categories', []);
            if (!empty($categories)) {
                $addon->categories()->sync($categories);
            }

            if ($request->hasFile('images')) {
                if ($addon->image) {
                    $oldPath = str_replace(URL::to('/storage/'), '', $addon->image);
                    Storage::disk('public')->delete($oldPath);
                }

                $relativePath = $request->file('images')[0]->store('addons', 'public');
                $fullUrl = URL::to(Storage::url($relativePath));
                $addon->update(['image' => $fullUrl]);
            }
        });

        return new AddonResource($addon->load('categories'));
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();
        return response()->json(['message' => 'Addon deleted successfully']);
    }
}
