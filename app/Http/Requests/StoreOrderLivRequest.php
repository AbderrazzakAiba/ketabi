<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\OrderStatus; // Import OrderStatus
use App\Models\OrderLiv; // Import OrderLiv model

class StoreOrderLivRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'create' ability on the OrderLiv model can make this request
        return $this->user()->can('create', OrderLiv::class);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_User' => 'exists:users,id_User',
            'title' => 'required|string',
            'auteur' => 'required|string',
            'category' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'id_user.required' => 'معرف المستخدم مطلوب',
            'id_user.exists' => 'المستخدم المحدد غير موجود',
            'title.required' => 'عنوان الكتاب مطلوب',
            'title.string' => 'عنوان الكتاب يجب أن يكون نصاً',
            'auteur.required' => 'اسم المؤلف مطلوب',
            'auteur.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'category.required' => 'التصنيف مطلوب',
            'category.string' => 'التصنيف يجب أن يكون نصاً',
        ];
    }
}
