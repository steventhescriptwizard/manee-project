<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_name',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
        'min_purchase',
        'max_discount',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_products');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_categories');
    }
}
