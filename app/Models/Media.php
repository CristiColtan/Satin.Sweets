<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Media extends Model
{
    use HasFactory;

    protected $fillable = ['url', 'alt_text'];

    protected $appends = ['full_url']; // 👈 îl includem automat în răspunsul JSON

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_media')
            ->withPivot('role')
            ->withTimestamps();
    }

    // 👇 Aici generăm adresa completă pentru frontend
    public function getFullUrlAttribute()
    {
        if (!$this->url) {
            return null;
        }

        // Dacă url-ul începe deja cu http, îl lăsăm așa
        if (str_starts_with($this->url, 'http')) {
            return $this->url;
        }

        // Altfel generăm adresa completă pentru fișierele din storage
        return Storage::url($this->url);
    }
}
