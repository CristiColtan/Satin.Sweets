<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Addon extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'sub_type',
        'hex_code',
        'description',
        'image',
        'is_active',
        'price',
        'created_by',
        'updated_by',
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'hex_code' => $this->hex_code,
            'is_active' => (bool)$this->is_active,
            'price' => (float)$this->price,
            'created_at' => optional($this->created_at)->toISOString(),
            'updated_at' => optional($this->updated_at)->toISOString(),
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'addons_categories');
    }
}
