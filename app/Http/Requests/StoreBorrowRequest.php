<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\LoanType; // Import LoanType
use Illuminate\Support\Facades\Auth; // Import Auth facade
use App\Enums\UserStatus; // Import UserStatus
use App\Models\Borrow; // Import Borrow model
use App\Enums\UserRole; // Import UserRole enum

class StoreBorrowRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // All authenticated users can initiate a borrow request if their account is approved
        // Additional authorization logic can be added in the BorrowPolicy
        $user = $this->user(); // Get the authenticated user
        return $user && $user->isApproved(); // Check if user exists and is approved
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

        // Determine max borrows based on user role
        switch ($user->role) {
            case UserRole::STUDENT:
                $maxBorrows = 3;
                break;
            case UserRole::PROFESSOR:
                $maxBorrows = 5;
                break;
            case UserRole::EMPLOYEE:
                $maxBorrows = 3; // Assuming employee limit is same as student for now
                break;
            default:
                // Admin or other roles might have different limits or no limits
                // For now, assume no borrowing for other roles via this request
                $maxBorrows = 0;
                break;
        }

        $user = $this->user(); // Get the authenticated user

        $maxBorrows = 0;
        $allowedLoanTypes = array_column(LoanType::cases(), 'value'); // Default: all loan types allowed

        // Determine max borrows and allowed loan types based on user role
        switch ($user->role) {
            case UserRole::STUDENT:
                $maxBorrows = 3;
                break;
            case UserRole::PROFESSOR:
                $maxBorrows = 5;
                break;
            case UserRole::EMPLOYEE:
                $maxBorrows = 3; // Employee limit for borrowing
                // Restrict employee loan types to IN_LIBRARY and EXTERNAL
                $allowedLoanTypes = [LoanType::IN_LIBRARY->value, LoanType::EXTERNAL->value];
                break;
            // Admin might not typically borrow, or have a different limit/process.
            // Assuming Admins can borrow with employee limit and types for now if needed.
            case UserRole::ADMIN:
                 $maxBorrows = 3; // Assuming Admin can borrow like an employee
                 $allowedLoanTypes = [LoanType::IN_LIBRARY->value, LoanType::EXTERNAL->value]; // Assuming Admin borrowing is similar to employee
                 break;
            default:
                // Other roles might not be allowed to borrow
                $maxBorrows = 0;
                $allowedLoanTypes = [];
                break;
        }

        $user = $this->user(); // Get the authenticated user

        $maxBorrows = 0;
        $allowedLoanTypes = array_column(LoanType::cases(), 'value'); // Default: all loan types allowed

        // Determine max borrows and allowed loan types based on user role
        switch ($user->role) {
            case UserRole::STUDENT:
                $maxBorrows = 3;
                break;
            case UserRole::PROFESSOR:
                $maxBorrows = 5;
                break;
            case UserRole::EMPLOYEE:
                $maxBorrows = 3; // Employee limit for borrowing
                // Restrict employee loan types to IN_LIBRARY and EXTERNAL
                $allowedLoanTypes = [LoanType::IN_LIBRARY->value, LoanType::EXTERNAL->value];
                break;
            // Admin might not typically borrow, or have a different limit/process.
            // Assuming Admins can borrow with employee limit and types for now if needed.
            case UserRole::ADMIN:
                 $maxBorrows = 3; // Assuming Admin can borrow like an employee
                 $allowedLoanTypes = [LoanType::IN_LIBRARY->value, LoanType::EXTERNAL->value]; // Assuming Admin borrowing is similar to employee
                 break;
            default:
                // Other roles might not be allowed to borrow
                $maxBorrows = 0;
                $allowedLoanTypes = [];
                break;
        }

        return [
            'copy_id' => [
                'required',
                'exists:copies,id_exemplaire',
                // Add a custom rule to check borrowing limit
                function ($attribute, $value, $fail) use ($user, $maxBorrows) {
                    if ($maxBorrows > 0) {
                        $currentBorrows = Borrow::where('id_User', $user->id_User)
                                                ->whereNull('date_retour') // Assuming date_retour is null for active borrows
                                                ->count();

                        if ($currentBorrows >= $maxBorrows) {
                            $fail("لا يمكنك استعارة أكثر من {$maxBorrows} كتب.");
                        }
                    } else {
                         $fail("دور المستخدم الحالي غير مسموح له بالاستعارة.");
                    }
                },
            ],
            'type' => ['required', Rule::in($allowedLoanTypes)], // Validate loan type based on allowed types
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
            'copy_id.required' => 'معرف النسخة مطلوب.',
            'copy_id.exists' => 'النسخة المحددة غير موجودة.',
            'type.required' => 'نوع الإعارة مطلوب.',
            'type.in' => 'نوع الإعارة المحدد غير صالح.',
            // Custom message for the borrowing limit rule is handled within the closure
        ];
    }
}
