<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\CopyStatus; // Import CopyStatus
use App\Models\Copy; // Import Copy model

class StoreCopyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'create' ability on the Copy model can make this request
        return $this->user()->can('create', Copy::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_achat' => 'required|date',
            'etat_copy_liv' => ['required', 'string', Rule::in(array_column(CopyStatus::cases(), 'value'))],
            'id_book' => 'required|exists:books,id_book',
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
