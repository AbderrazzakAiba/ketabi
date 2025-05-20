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
        return ($this->user() instanceof \App\Models\User) && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required',  Rule::in([OrderStatus::APPROVED->value, OrderStatus::REJECTED->value])],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'حالة الطلب مطلوبة',
            'status.in' => 'حالة الطلب المدخلة غير صالحة. يجب أن تكون "approved" أو "rejected".',
        ];
    }
}
