<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = static::generateOrderNumber();
            }
        });
    }

    public static function generateOrderNumber()
    {
        $prefix = 'MN';
        $date = now()->format('ymd');
        $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
        
        $orderNumber = "{$prefix}-{$date}-{$random}";

        // Ensure uniqueness
        while (static::where('order_number', $orderNumber)->exists()) {
            $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
            $orderNumber = "{$prefix}-{$date}-{$random}";
        }

        return $orderNumber;
    }

    protected $fillable = [
        'user_id',
        'order_number',
        'total_price',
        'status',
        'shipping_address_id',
        'shipping_method',
        'payment_method',
        'payment_status',
        'snap_token',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(CustomerAddress::class, 'shipping_address_id');
    }

    public function getTrackingAttribute()
    {
        $statusOrder = ['pending', 'processing', 'shipped', 'out_for_delivery', 'completed'];
        $currentStatusIndex = array_search($this->status, $statusOrder);
        
        $steps = [
            (object)['label' => 'Dipesan', 'date' => $this->created_at->format('d M'), 'time' => $this->created_at->format('H:i'), 'completed' => $currentStatusIndex >= 0],
            (object)['label' => 'Diproses', 'completed' => $currentStatusIndex >= 1],
            (object)['label' => 'Dikirim', 'completed' => $currentStatusIndex >= 2],
            (object)['label' => 'Di Antar', 'completed' => $currentStatusIndex >= 3],
            (object)['label' => 'Selesai', 'completed' => $currentStatusIndex >= 4],
        ];

        $currentLocation = match ($this->status) {
            'shipped' => 'Dalam Perjalanan',
            'out_for_delivery' => 'Sedang Diantar Kurir',
            'completed' => 'Diterima',
            default => 'Gudang Pusat',
        };

        return (object)[
            'steps' => $steps,
            'estimatedArrival' => $this->created_at->addDays(3)->format('d M Y'),
            'currentLocation' => $currentLocation,
        ];
    }

    public function getSummaryAttribute()
    {
        $subtotal = $this->items->sum(fn($item) => $item->price * $item->quantity);
        return (object)[
            'subtotal' => $subtotal,
            'shipping' => 15000,
            'discount' => 0,
            'tax' => 0,
            'total' => $this->total_price,
            'status' => $this->payment_status === 'paid' ? 'Lunas' : 'Belum Bayar',
        ];
    }
}
