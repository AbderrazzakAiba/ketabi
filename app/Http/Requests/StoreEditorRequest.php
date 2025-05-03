<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Models\Editor; // Import Editor model

class StoreEditorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'create' ability on the Editor model can make this request
        return $this->user()->can('create', Editor::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_ed' => 'required|string|max:255',
            'adress_ed' => 'required|string|max:255',
            'city_ed' => 'required|string|max:255',
            'email_ed' => 'required|email|unique:editors,email_ed',
            'tel_ed' => 'required|string|max:20',
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
            'name_ed.required' => 'اسم دار النشر مطلوب.',
            'name_ed.string' => 'اسم دار النشر يجب أن يكون نصاً.',
            'name_ed.max' => 'اسم دار النشر لا يمكن أن يتجاوز 255 حرفاً.',
            'adress_ed.required' => 'عنوان دار النشر مطلوب.',
            'adress_ed.string' => 'عنوان دار النشر يجب أن يكون نصاً.',
            'adress_ed.max' => 'عنوان دار النشر لا يمكن أن يتجاوز 255 حرفاً.',
            'city_ed.required' => 'مدينة دار النشر مطلوبة.',
            'city_ed.string' => 'مدينة دار النشر يجب أن تكون نصاً.',
            'city_ed.max' => 'مدينة دار النشر لا يمكن أن تتجاوز 255 حرفاً.',
            'email_ed.required' => 'البريد الإلكتروني لدار النشر مطلوب.',
            'email_ed.email' => 'البريد الإلكتروني لدار النشر يجب أن يكون عنوان بريد إلكتروني صالحاً.',
            'email_ed.unique' => 'البريد الإلكتروني لدار النشر مُستخدم بالفعل.',
            'tel_ed.required' => 'رقم هاتف دار النشر مطلوب.',
            'tel_ed.string' => 'رقم هاتف دار النشر يجب أن يكون نصاً.',
            'tel_ed.max' => 'رقم هاتف دار النشر لا يمكن أن يتجاوز 20 حرفاً.',
        ];
    }
}
