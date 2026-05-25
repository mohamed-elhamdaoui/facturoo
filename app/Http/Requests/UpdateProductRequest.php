<?php

namespace App\Http\Requests;

use App\Enums\ProductCategory;
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
            'category'       => ['nullable', 'string', Rule::in(ProductCategory::values())],
            'name'           => ['required', 'string', 'max:255'],
            'price'          => ['required', 'numeric', 'min:0'],
            'image'          => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'min_stock'      => ['nullable', 'integer', 'min:0'],
        ];
    }
}
