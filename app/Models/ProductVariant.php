<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'attributes',
        'color',
        'size',
        'price',
        'track_inventory',
        'weight',
        'unit_of_measure',
    ];

    protected $casts = [
        'attributes' => 'array',
        'track_inventory' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class, 'variant_id');
    }
}
