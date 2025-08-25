<?php

namespace App\Http\Requests\Sel\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ProductRequest
 *
 * Validation pour création / mise à jour de Product.
 */
class ProductRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Règles de validation.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_id' => ['nullable', 'exists:discounts,id'],
            'available_at' => ['nullable', 'date'],
            'status_id' => ['nullable', 'exists:statuses,id'],
            'slug' => ['nullable', 'string', 'max:255'],
            'weight' => ['nullable', 'numeric'],
            'height' => ['nullable', 'numeric'],
            'images' => ['sometimes', 'array'],
            'images.*' => ['image', 'max:5120'],
            'folder' => ['sometimes', 'string', 'max:255'],
            'remove_image_ids' => ['sometimes', 'array'],
            'remove_image_ids.*' => ['integer', 'exists:product_images,id'],
            'main_image_id' => ['sometimes', 'nullable', 'integer', 'exists:product_images,id'],
        ];
    }

    /**
     * Messages personnalisés.
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
