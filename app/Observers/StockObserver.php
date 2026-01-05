<?php

namespace App\Observers;

use App\Models\Stock;
use App\Models\User;
use App\Notifications\LowStockNotification;
use Illuminate\Support\Facades\Notification;

class StockObserver
{
    /**
     * Handle the Stock "updated" event.
     */
    public function updated(Stock $stock): void
    {
        // Check if stock dropped below threshold (default 5 if not set)
        $threshold = $stock->minimum_stock ?? 5;

        // Trigger only if stock is below threshold and wasn't already below (to avoid spam)
        // Or simply trigger every time it drops below. Let's trigger if current <= threshold.
        // Optimization: check if original 'current_stock' was > threshold to only notify on crossing the line.
        
        $originalStock = $stock->getOriginal('current_stock');
        
        if ($stock->current_stock <= $threshold && $originalStock > $threshold) {
            $admins = User::where('role', 'admin')->get();
            Notification::send($admins, new LowStockNotification($stock));
        }
    }
}
