<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_name' => 'required|string|max:255',
            'sku' => ['required', 'string', 'max:100', Rule::unique('products')->ignore($this->product)],
            'barcode' => ['nullable', 'string', 'max:100', Rule::unique('products')->ignore($this->product)],
            'price' => 'required|numeric|min:0',
            'image_main' => 'nullable|image|max:3072',
            'product_gallery' => 'nullable|array',
            'product_gallery.*' => 'image|max:3072',
            'description' => 'nullable|string',
            'details_and_care' => 'nullable|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'track_inventory' => 'boolean',
            'current_stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
            'is_new_arrival' => 'boolean',
            'is_best_seller' => 'boolean',
            'on_sale' => 'boolean',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'track_inventory' => $this->has('track_inventory'),
            'is_new_arrival' => $this->has('is_new_arrival'),
            'is_best_seller' => $this->has('is_best_seller'),
            'on_sale' => $this->has('on_sale'),
        ]);
    }
}
