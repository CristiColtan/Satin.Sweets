<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /*
     User → Checkout
     ↓
     Order created (status = pending)
     ↓
     Payment created (status = pending)
     ↓
     [procesator]
     ↓
     Webhook OK
     ↓
     Payment → confirmed
     ↓
     Order → processing
    */

    /*
    Status flow:
    1. în așteptare(pending) -- comandă plasată de client, plata în curs
    2. în procesare(processing) -- comandă platită, urmează a fi prelucrată
    3. în prelucrare(preparing) -- comandă este în curs de pregătire
    4. în tranzit(shipped) -- comanda este predată curierului și este în drum spre tine
    5. Livrat(delivered) -- comanda a fost livrată cu succes.
    6. Livrare eșuată(delivery failed) -- comanda nu a fost ridicată de către destinatar
    7. Anulat(canceled) -- comanda a fost anulată de client
    */

    protected $fillable = [
        'order_number',

        'total_price',

        'subtotal',
        'transport',
        'discount',
        'coupon_code',

        'delivery_date',
        'payment_method',

        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'transport' => 'decimal:2',
        'discount' => 'decimal:2',

        'delivery_date' => 'date',
    ];

    protected $appends = ['is_paid', 'payment_status', 'paid_method'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function details()
    {
        return $this->hasOne(OrderDetail::class);
    }

    public function getDisplayNumberAttribute(): string
    {
        return $this->order_number
            ? ('#' . $this->order_number)
            : ('#' . $this->id);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function lastPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function getIsPaidAttribute(): bool
    {
        return $this->lastPayment?->status === 'confirmed';
    }

    public function getPaymentStatusAttribute(): string
    {
        return $this->lastPayment?->status ?? 'pending';
    }

    public function getPaidMethodAttribute(): ?string
    {
        return $this->lastPayment?->type;
    }

    public function setStatus(string $status, ?int $userId = null): void
    {
        $this->update(['status' => $status, 'updated_by' => $userId]);
        $this->statusLogs()->create(['status' => $status]);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class)->orderBy('created_at');
    }
}
