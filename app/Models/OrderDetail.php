<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $incrementing = false;
    protected $table = 'order_details';
    protected $primaryKey = 'order_id';
    protected $keyType = 'int';

    protected $fillable = [
        'order_id',

        'first_name',
        'last_name',
        'phone_number',
        'email',

        'address',
        'city',
        'state',
        'zipcode',

        'country_code',
        'invoice_details',
    ];

    protected $casts = [
        'invoice_details' => 'array'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function hasInvoice(): bool
    {
        return !empty($this->invoice_details);
    }
}
