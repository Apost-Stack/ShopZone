<?php

namespace App\Http\Requests\Action;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // ajustez si vous avez une logique d'autorisation
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reference' => 'nullable|string|max:191',
            'delivery_id' => 'nullable|exists:deliveries,id',
            'customer_id' => 'required|exists:customers,id',
            'order_status' => 'required|string',
            'status_id' => 'nullable|integer',
            'payment_method' => 'required|string',
            'discount_id' => 'nullable|exists:discounts,id',
            'total_product' => 'nullable|integer|min:0',
            'price_total' => 'required|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'cash_paid' => 'nullable|numeric|min:0',
            'label_url' => 'nullable|string|max:255',

            // produits (optionnel) : array of items with id, quantity, unit_price, discount_percent
            'products' => 'nullable|array',
            'products.*.id' => 'required_with:products|exists:products,id',
            'products.*.quantity' => 'required_with:products|integer|min:1',
            'products.*.unit_price' => 'required_with:products|numeric|min:0',
            'products.*.discount_percent' => 'nullable|numeric|min:0|max:100',
        ];
    }
}
