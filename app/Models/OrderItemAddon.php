<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItemAddon extends Model
{
    use HasFactory;

    protected $fillable = ['order_item_id', 'addon_id', 'type', 'label', 'value', 'price'];

    protected $casts = ['price' => 'decimal:2', 'value' => 'array'];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}
