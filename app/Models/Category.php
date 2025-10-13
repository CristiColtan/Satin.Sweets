<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'parent_id', 'created_by', 'updated_by', 'deleted_by'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'categories_products');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parentName(): ?string
    {
        return $this->parent ? $this->parent->name : null;
    }
}
