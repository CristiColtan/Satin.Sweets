<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_subtotal',
        'is_active',
        'starts_at',
        'expires_at',
        'usage_limit',
        'used_count'
    ];
    protected $casts = [
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime'
    ];

    public function isValidNow()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();
        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }
        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function computeDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_subtotal) {
            return 0.00;
        }

        if ($this->type === 'percent') {
            return round($subtotal * ($this->value / 100), 2);
        }

        return round(min($this->value, $subtotal), 2);
    }
}
