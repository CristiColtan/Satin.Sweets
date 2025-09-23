<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'alt_text'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_media')->withPivot('role')->withTimestamps();
    }
}
