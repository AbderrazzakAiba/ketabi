<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule

class StoreEtudiantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization is handled in the controller using policies
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:utilisateurs,email',
            'level' => 'required|string',
            'academic_year' => 'required|date',
            'speciality' => 'required|string',
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
            'first_name.required' => 'الاسم الأول مطلوب.',
            'last_name.required' => 'الاسم الأخير مطلوب.',
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'البريد الإلكتروني يجب أن يكون عنوان بريد إلكتروني صالحاً.',
            'email.unique' => 'البريد الإلكتروني مُستخدم بالفعل.',
            'level.required' => 'المستوى مطلوب.',
            'academic_year.required' => 'السنة الدراسية مطلوبة.',
            'academic_year.date' => 'السنة الدراسية يجب أن تكون تاريخاً صالحاً.',
            'speciality.required' => 'التخصص مطلوب.',
        ];
    }
}
