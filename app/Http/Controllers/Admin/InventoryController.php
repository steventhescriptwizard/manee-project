<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::with(['product', 'variant', 'warehouse']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            })->orWhereHas('variant', function($q) use ($search) {
                $q->where('sku', 'like', "%{$search}%")
                  ->orWhere('color', 'like', "%{$search}%")
                  ->orWhere('size', 'like', "%{$search}%");
            });
        }

        $stocks = $query->latest('last_stock_update')
            ->paginate(10)
            ->withQueryString();
            
        return view('admin.inventory.index', compact('stocks'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'adjustment_type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $quantity = $request->quantity;
        $type = strtoupper($request->adjustment_type);

        if ($type === 'IN') {
            $stock->increment('current_stock', $quantity);
            $stock->increment('stock_in', $quantity);
        } else {
            $stock->decrement('current_stock', $quantity);
            $stock->increment('stock_out', $quantity);
        }

        $stock->update(['last_stock_update' => now()]);

        // Log the movement
        \App\Models\StockMovement::create([
            'product_id' => $stock->product_id,
            'variant_id' => $stock->variant_id,
            'warehouse_id' => $stock->warehouse_id,
            'type' => $type,
            'quantity' => $quantity,
            'reference_type' => 'adjustment',
            'user_id' => auth()->id(),
            'notes' => $request->notes ?? 'Manual Stock Adjustment',
        ]);

        return back()->with('success', 'Stock adjusted successfully.');
    }

    public function logs()
    {
        $movements = \App\Models\StockMovement::with(['product', 'variant', 'warehouse', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.inventory.logs', compact('movements'));
    }
}
