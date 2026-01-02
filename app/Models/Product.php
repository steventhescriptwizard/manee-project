<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $with = ['taxes'];

    protected $fillable = [
        'product_name',
        'sku',
        'barcode',
        'price',
        'description',
        'details_and_care',
        'image_main',
        'track_inventory',
        'weight',
        'unit_of_measure',
        'is_new_arrival',
        'is_best_seller',
        'on_sale',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->where('is_published', true);
    }

    public function taxes()
    {
        return $this->belongsToMany(Tax::class, 'product_tax');
    }

    /**
     * Calculate tax amount for the product
     */
    public function getTaxAmount()
    {
        $taxAmount = 0;
        foreach ($this->taxes as $tax) {
            if ($tax->is_active) {
                // Assuming simple percentage tax for now
                // rate is stored as percentage (e.g. 11 for 11%)
                $taxAmount += $this->price * ($tax->rate / 100);
            }
        }
        return $taxAmount;
    }

    /**
     * Get price including tax
     */
    public function getPriceWithTax()
    {
        return $this->price + $this->getTaxAmount();
    }

    public function getFinalPriceAttribute()
    {
        return $this->getPriceWithTax();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }
}
