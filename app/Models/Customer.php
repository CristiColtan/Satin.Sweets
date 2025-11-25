<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'phone_number',
        'status'
    ];
    protected $primaryKey = 'user_id';
    protected $keyType = 'int';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
