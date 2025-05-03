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
            'phone_number'  => 'required|string|max:20',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'role'          => ['required', 'string', Rule::in(array_column(UserRole::cases(), 'value'))],

            // Role-specific fields
            'affiliation'   => 'sometimes|required_if:role,' . UserRole::PROFESSOR->value . '|string|max:255',

            'level'         => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|string|max:255',
            'academic_year' => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|date_format:Y-m-d',
            'speciality'    => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|string|max:255',
            'matricule'     => 'sometimes|required_if:role,' . UserRole::STUDENT->value . '|string|max:50|unique:etudiants,matricule',
        ];
    }
}
