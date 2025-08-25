<?php

namespace App\Http\Requests\Action;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeliveryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $deliveryId = $this->route('delivery')?->deliveryId ?? null;

        return [
            'name' => [
                'required',
                'string',
                'max:191',
                Rule::unique('deliveries', 'name')->ignore($deliveryId, 'deliveryId')
            ],
            'province_id' => 'nullable|exists:provinces,id',
            'address' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
            'status_id' => 'nullable|exists:statuses,id',
            'employee_id' => 'nullable|exists:employees,id',
            'discount_id' => 'nullable|exists:discounts,id',
        ];
    }
}
