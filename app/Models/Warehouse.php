<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address',
        'city',
        'country',
    ];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    
    // Assuming you might eventually have usage for movements by warehouse
    public function movements()
    {
        return $this->hasMany(StockMovement::class);
    }
}
