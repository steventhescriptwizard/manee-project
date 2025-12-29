<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_name',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
        'minimum_purchase',
        'usage_limit',
        'usage_count',
    ];

    /**
     * Check if discount is valid for use
     */
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if discount can be applied to cart subtotal
     */
    public function canBeApplied($subtotal)
    {
        if (!$this->isValid()) {
            return false;
        }

        if ($this->minimum_purchase && $subtotal < $this->minimum_purchase) {
            return false;
        }

        return true;
    }

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

    /**
     * Calculate discount amount for cart items
     * 
     * @param array $cart
     * @return float
     */
    public function calculateDiscount($cart)
    {
        if (!$this->isValid()) {
            return 0;
        }

        $categories = $this->categories()->pluck('categories.id')->toArray();
        $products = $this->products()->pluck('products.id')->toArray();
        
        $eligibleTotal = 0;
        $totalCartValue = 0;

        foreach ($cart as $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $totalCartValue += $itemTotal;

            $isEligible = true;

            // If category restrictions exist, check if item's category matches
            if (!empty($categories)) {
                $product = Product::find($item['id']);
                if (!$product || !in_array($product->category_id, $categories)) {
                    $isEligible = false;
                }
            }

            // If product restrictions exist, check if item matches (overrides or adds to category check? usually cumulative)
            // Logic: If eligible by category AND eligible by product (if specified). 
            // OR: If product list is specific, it might bypass category?
            // Safer logic: Filter by EITHER if both exist? No, usually constraints are AND.
            // Let's assume standard logic: 
            // 1. If NO restrictions (global) -> All eligible.
            // 2. If Categories ONLY -> Must be in category.
            // 3. If Products ONLY -> Must be in product list.
            // 4. If BOTH -> Must be in category OR in product list? Or AND? 
            // Usually "Apply to these categories AND these products" implies a union of sets (OR).
            
            // Let's implement UNION logic (Eligible if in Category OR Eligible if Product)
            // But wait, if I select Category A, and Product B (from Category C). I expect both to be discounted.
            
            if (!empty($categories) || !empty($products)) {
                 $isEligible = false;
                 $product = Product::find($item['id']);

                 if ($product) {
                     if (!empty($categories) && in_array($product->category_id, $categories)) {
                         $isEligible = true;
                     }
                     if (!empty($products) && in_array($product->id, $products)) {
                         $isEligible = true;
                     }
                 }
            } else {
                // Global discount
                $isEligible = true;
            }

            if ($isEligible) {
                $eligibleTotal += $itemTotal;
            }
        }

        // Min purchase validation usually applies to the SUBTOTAL, not just eligible total? 
        // Standard e-commerce: Min purchase applies to CART VALUE.
        if ($this->minimum_purchase && $totalCartValue < $this->minimum_purchase) {
            return 0;
        }

        if ($this->discount_type === 'PERCENT') {
            $discountAmount = $eligibleTotal * ($this->discount_value / 100);
            if ($this->max_discount && $discountAmount > $this->max_discount) {
                $discountAmount = $this->max_discount;
            }
            return $discountAmount;
        } else {
            // Fixed discount is tricky. Does it apply once per order? Or per item?
            // Usually Fixed Amount off the ORDER.
            // If restricted items exist, we ensure eligible items total >= fixed amount? 
            // Or just deduct fixed amount if ANY eligible item exists?
            
            // Logic: Flat discount applies if eligible items exist with enough value.
            if ($eligibleTotal > 0) {
                 return min($this->discount_value, $eligibleTotal); // Cannot discount more than the value of items
            }
            return 0;
        }
    }
}
