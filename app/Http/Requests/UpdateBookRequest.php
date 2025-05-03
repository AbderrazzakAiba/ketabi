<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\BookStatus; // Import BookStatus
use App\Models\Book; // Import Book model

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'update' ability on the specific Book model can make this request
        $book = $this->route('book'); // Get the book model from the route
        return $this->user()->can('update', $book);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'auteur' => 'sometimes|required|string|max:255',
            'num_page' => 'sometimes|nullable|integer',
            'num_RGE' => 'sometimes|nullable|string|max:255',
            'category' => 'sometimes|nullable|string|max:255',
            'quantite' => 'sometimes|required|integer|min:0', // Allow 0 for quantity update
            'etat_liv' => ['sometimes', 'nullable', 'string', Rule::in(array_column(BookStatus::cases(), 'value'))], // Consider using Enum
            'id_editor' => 'sometimes|nullable|exists:editors,id_editor',
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
            'title.required' => 'عنوان الكتاب مطلوب.',
            'title.string' => 'عنوان الكتاب يجب أن يكون نصاً.',
            'title.max' => 'عنوان الكتاب لا يمكن أن يتجاوز 255 حرفاً.',
            'auteur.required' => 'اسم المؤلف مطلوب.',
            'auteur.string' => 'اسم المؤلف يجب أن يكون نصاً.',
            'auteur.max' => 'اسم المؤلف لا يمكن أن يتجاوز 255 حرفاً.',
            'num_page.integer' => 'عدد الصفحات يجب أن يكون عدداً صحيحاً.',
            'quantite.required' => 'كمية النسخ مطلوبة.',
            'quantite.integer' => 'كمية النسخ يجب أن تكون عدداً صحيحاً.',
            'quantite.min' => 'كمية النسخ يجب أن تكون على الأقل 0.',
            'etat_liv.in' => 'حالة الكتاب المدخلة غير صالحة.',
            'id_editor.exists' => 'دار النشر المحددة غير موجودة.',
        ];
    }
}
