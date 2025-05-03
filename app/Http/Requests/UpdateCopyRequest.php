<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\CopyStatus; // Import CopyStatus
use App\Models\Copy; // Import Copy model

class UpdateCopyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'update' ability on the specific Copy model can make this request
        $copy = $this->route('copy'); // Get the copy model from the route
        return $this->user()->can('update', $copy);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_achat' => 'sometimes|required|date',
            'etat_copy_liv' => ['sometimes', 'required', 'string', Rule::in(array_column(CopyStatus::cases(), 'value'))],
            'id_book' => 'sometimes|required|exists:books,id_book',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date_achat.required' => 'تاريخ الشراء مطلوب.',
            'date_achat.date' => 'تاريخ الشراء يجب أن يكون تاريخاً صالحاً.',
            'etat_copy_liv.required' => 'حالة النسخة مطلوبة.',
            'etat_copy_liv.string' => 'حالة النسخة يجب أن تكون نصاً.',
            'etat_copy_liv.in' => 'حالة النسخة المدخلة غير صالحة.',
            'id_book.required' => 'معرف الكتاب مطلوب.',
            'id_book.exists' => 'الكتاب المحدد غير موجود.',
        ];
    }
}
