<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $stocks = Stock::with(['product', 'variant', 'warehouse'])
            ->latest('last_stock_update')
            ->paginate(15);
            
        return view('admin.inventory.index', compact('stocks'));
    }
}
