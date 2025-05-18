<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\BorrowStatus; // Import BorrowStatus

class UpdateBorrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization will be handled in the controller using policies
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
            'date_retour' => 'nullable|date', // Validation for return date
            'borrow_status' => ['nullable', Rule::in(array_column(BorrowStatus::cases(), 'value'))], // Validation for borrow status
            // Add other fields that can be updated on a borrow record if necessary
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
            'return_date.date' => 'تاريخ الإرجاع يجب أن يكون تاريخاً صحيحاً.',
            'borrow_status.in' => 'حالة الإعارة المدخلة غير صالحة.',
        ];
    }
}
