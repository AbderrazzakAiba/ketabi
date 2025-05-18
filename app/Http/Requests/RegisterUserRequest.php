<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserRole;

class RegisterUserRequest extends FormRequest
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
        return [
            // Common fields
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'adress'        => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'phone_number'  => ['required', 'string', 'regex:/^(05|06|07)\d{8}$/'], // 10 digits, starts with 05, 06, or 07
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'lieu_de_naissance' => ['nullable', 'string', 'max:255'], // Add validation for lieu_de_naissance
            'date_de_naissance' => ['nullable', 'date'], // Add validation for date_de_naissance
            'role'          => ['required', 'string', Rule::in(array_column(UserRole::cases(), 'value'))],

            // Role-specific fields
            'affiliation'   => 'sometimes|required_if:role,' . UserRole::PROFESSOR->value . '|string|max:255',

            'level'         => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|string|max:255',
            'academic_year' => [
                              'sometimes',
                             'required_if:role,' . UserRole::STUDENT->value,
                            'regex:/^20\d{2}-20\d{2}$/',
                              function ($attribute, $value, $fail) {
                              [$start, $end] = explode('-', $value);

                               $startYear = (int) $start;
                               $endYear = (int) $end;

                                $startSuffix = (int) substr($start, 2); // آخر رقمين من السنة الأولى
                                $endSuffix = (int) substr($end, 2);     // آخر رقمين من السنة الثانية

                                if ($startSuffix < 24) {
                                     return $fail('يجب أن لا تقل السنة الأولى عن 2024.');
                               }

                               if ($endSuffix !== $startSuffix + 1) {
                                       return $fail('السنة الثانية يجب أن تساوي السنة الأولى زائد 1.');
                               }
                               },
                              ],
            'speciality'    => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|string|max:255',
            'matricule'     => ['sometimes', 'required_if:role,' . UserRole::STUDENT->value, 'digits:12', 'numeric', 'unique:etudiants,matricule'], // Ensure matricule is 12 digits and numeric
        ];
    }
}
