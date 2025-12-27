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
            'image_main' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
            'track_inventory' => 'boolean',
            'weight' => 'nullable|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'track_inventory' => $this->has('track_inventory'),
        ]);
    }
}
