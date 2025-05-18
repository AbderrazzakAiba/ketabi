<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\LoanType;
use App\Enums\BorrowStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\Borrow;

class StoreBorrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and approved
        return Auth::check() && Auth::user()->status === \App\Enums\UserStatus::APPROVED;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = Auth::user();
        $maxBorrows = 0;

        switch ($user->role) {
            case \App\Enums\UserRole::STUDENT:
                $maxBorrows = 3;
                break;
            case \App\Enums\UserRole::PROFESSOR:
                $maxBorrows = 5;
                break;
            case \App\Enums\UserRole::EMPLOYEE:
            case \App\Enums\UserRole::ADMIN:
                $maxBorrows = 3;
                break;
            default:
                $maxBorrows = 0;
                break;
        }

        $rules = [
            'type' => ['required', Rule::in(array_column(LoanType::cases(), 'value'))],
            'duration' => [
                Rule::requiredIf(function () {
                    return in_array(request('type'), [LoanType::EXTERNAL->value, LoanType::ONLINE_RETURN->value]);
                }),
                'nullable',
                'integer',
                'min:1',
                'max:15',
            ],
        ];

        if (request('type') === LoanType::ONLINE_RETURN->value || request('type') === LoanType::ONLINE_DOWNLOAD->value) {
            $rules['id_book'] = ['required', 'exists:books,id_book'];
        } else {
            $rules['copy_id'] = ['required', 'exists:copies,id_exemplaire'];
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'type.required' => 'نوع الإعارة مطلوب.',
            'type.in' => 'نوع الإعارة المحدد غير صالح.',
            'duration.required' => 'مدة الإعارة مطلوبة.',
            'duration.integer' => 'مدة الإعارة يجب أن تكون عددًا صحيحًا.',
            'duration.min' => 'يجب أن تكون مدة الإعارة أكبر من 0.',
            'duration.max' => 'يجب ألا تتجاوز مدة الإعارة 15 يومًا.',
        ];

        if (request('type') === LoanType::ONLINE_RETURN->value || request('type') === LoanType::ONLINE_DOWNLOAD->value) {
            $messages['id_book.required'] = 'معرف الكتاب مطلوب.';
            $messages['id_book.exists'] = 'الكتاب المحدد غير موجود.';
        } else {
            $messages['copy_id.required'] = 'معرف النسخة مطلوب.';
            $messages['copy_id.exists'] = 'النسخة المحددة غير موجودة.';
        }

        return $messages;
    }
}
