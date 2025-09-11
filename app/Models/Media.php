<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_media')->withPivot('role')->withTimestamps();
    }
}
