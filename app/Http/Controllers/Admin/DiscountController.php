<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\Category;
use App\Models\Product;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::latest()->paginate(10);
        return view('admin.discounts.index', compact('discounts'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.discounts.create', compact('categories', 'products'));
    }

    public function store(StoreDiscountRequest $request)
    {
        $discount = Discount::create($request->validated());

        if ($request->has('categories')) {
            $discount->categories()->sync($request->categories);
        }

        if ($request->has('products')) {
            $discount->products()->sync($request->products);
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount created successfully.');
    }

    public function edit(Discount $discount)
    {
        $categories = Category::all();
        $products = Product::all();
        return view('admin.discounts.edit', compact('discount', 'categories', 'products'));
    }

    public function update(UpdateDiscountRequest $request, Discount $discount)
    {
        $discount->update($request->validated());

        if ($request->has('categories')) {
            $discount->categories()->sync($request->categories);
        } else {
            $discount->categories()->detach();
        }

        if ($request->has('products')) {
            $discount->products()->sync($request->products);
        } else {
            $discount->products()->detach();
        }

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('admin.discounts.index')
            ->with('success', 'Discount deleted successfully.');
    }
}
