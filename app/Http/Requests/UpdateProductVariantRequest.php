<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductVariantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variant_name' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:100',
            'size' => 'nullable|string|max:100',
            'sku' => ['nullable', 'string', 'max:100', Rule::unique('product_variants')->ignore($this->variant)],
            'price' => 'required|numeric|min:0',
            'track_inventory' => 'boolean',
            'current_stock' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'variant_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'track_inventory' => $this->has('track_inventory'),
        ]);
    }
}
