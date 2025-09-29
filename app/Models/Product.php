<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;
    use Searchable;

    protected $fillable = ['title', 'description', 'price', 'created_by', 'updated_by', 'deleted_by'];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function mainImage()
    {
        return $this->media()->wherePivot('role', 'main')->first();
    }

    public function media()
    {
        return $this->belongsToMany(Media::class, 'products_media')->withPivot('role')->withTimestamps();
    }

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function scopeName($query, $value)
    {
        return $query->where('title', 'like', "%$value%");
    }
}
