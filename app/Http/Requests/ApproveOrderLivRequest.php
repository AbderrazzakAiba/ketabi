<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\OrderStatus;

class ApproveOrderLivRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only admins can approve or reject requests
        return auth()->guard('sanctum')->user()->role === 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'string', Rule::in([OrderStatus::APPROVED->value, OrderStatus::REJECTED->value])],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'status.required' => 'حالة الطلب مطلوبة',
            'status.string' => 'حالة الطلب يجب أن تكون نصاً',
            'status.in' => 'حالة الطلب المدخلة غير صالحة. يجب أن تكون "approved" أو "rejected".',
        ];
    }
}
