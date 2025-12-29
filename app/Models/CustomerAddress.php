<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'label',
        'recipient_name',
        'phone_number',
        'address_line',
        'city',
        'province',
        'postal_code',
        'is_primary',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
