<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\OrderStatus; // Import OrderStatus
use App\Models\OrderLiv; // Import OrderLiv model

class StoreOrderLivRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'create' ability on the OrderLiv model can make this request
        return $this->user()->can('create', OrderLiv::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'auteur' => 'required|string',
            'category' => 'required|string',
            'quantite' => 'required|integer',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'عنوان الكتاب مطلوب',
            'title.string' => 'عنوان الكتاب يجب أن يكون نصاً',
            'auteur.required' => 'اسم المؤلف مطلوب',
            'auteur.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'category.required' => 'التصنيف مطلوب',
            'category.string' => 'التصنيف يجب أن يكون نصاً',
            'quantite.required' => 'الكمية مطلوبة',
            'quantite.integer' => 'الكمية يجب أن تكون رقماً',
        ];
    }
}
