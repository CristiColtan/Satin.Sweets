<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $incrementing = false;
    protected $primaryKey = 'code';
    protected $keyType = 'string';

    protected $fillable = ['name', 'code', 'states'];

    protected $casts = [
        'states' => 'array'
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'country_code', 'code');
    }

    public function customerAddresses()
    {
        return $this->hasMany(CustomerAddress::class, 'country_code', 'code');
    }
}
