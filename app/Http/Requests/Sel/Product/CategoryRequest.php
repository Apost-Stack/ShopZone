<?php

namespace App\Http\Requests\Sel\Product;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CategoryRequest
 *
 * Validation pour création / mise à jour de Category.
 */
class CategoryRequest extends FormRequest
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
            'picture' => ['nullable', 'image', 'max:5120'],
            'status_id' => ['nullable', 'exists:statuses,id'],
            'folder' => ['sometimes', 'string', 'max:255'],
        ];
    }

    /**
     * Messages personnalisés (optionnel).
     *
     * @return array
     */
    public function messages(): array
    {
        return [];
    }
}
