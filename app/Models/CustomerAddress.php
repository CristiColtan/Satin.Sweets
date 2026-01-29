<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    public const TYPE_SHIPPING = 'shipping';
    public const TYPE_BILLING = 'billing';

    protected $table = 'customer_addresses';

    protected $fillable = [
        'customer_id',
        'country_code',

        'type',

        'first_name',
        'last_name',
        'email',
        'phone_number',

        'address',
        'city',
        'state',
        'zipcode',
    ];

    protected $attributes = ['type' => self::TYPE_SHIPPING];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = $value ?: self::TYPE_SHIPPING;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function scopeShipping($query)
    {
        return $query->where('type', self::TYPE_SHIPPING);
    }
}
