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
            'id_user' => 'required|exists:users,id_User',
            'title' => 'required|string',
            'auteur' => 'required|string',
            'num_page' => 'required|integer',
            'num_RGE' => 'required|integer',
            'category' => 'required|string',
            'quantite' => 'required|integer',
            'id_editor' => 'required|exists:editors,id_editor',
            'image_path' => 'nullable|string',
            'pdf_path' => 'nullable|string',
            'order_date' => 'required|date',
            'status' => ['required', 'string', Rule::in(array_column(OrderStatus::cases(), 'value'))],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'id_user.required' => 'معرف المستخدم مطلوب',
            'id_user.exists' => 'المستخدم المحدد غير موجود',
            'title.required' => 'عنوان الكتاب مطلوب',
            'title.string' => 'عنوان الكتاب يجب أن يكون نصاً',
            'auteur.required' => 'اسم المؤلف مطلوب',
            'auteur.string' => 'اسم المؤلف يجب أن يكون نصاً',
            'num_page.required' => 'عدد الصفحات مطلوب',
            'num_page.integer' => 'عدد الصفحات يجب أن يكون رقماً',
            'num_RGE.required' => 'رقم RGE مطلوب',
            'num_RGE.integer' => 'رقم RGE يجب أن يكون رقماً',
            'category.required' => 'التصنيف مطلوب',
            'category.string' => 'التصنيف يجب أن يكون نصاً',
            'quantite.required' => 'الكمية مطلوبة',
            'quantite.integer' => 'الكمية يجب أن تكون رقماً',
            'image_path.string' => 'مسار الصورة يجب أن يكون نصاً',
            'pdf_path.string' => 'مسار PDF يجب أن يكون نصاً',
            'order_date.required' => 'تاريخ الطلب مطلوب',
            'order_date.date' => 'تاريخ الطلب يجب أن يكون تاريخاً صالحاً',
            'status.required' => 'حالة الطلب مطلوبة',
            'status.string' => 'حالة الطلب يجب أن يكون نصاً',
            'status.in' => 'حالة الطلب المدخلة غير صالحة',
            'id_editor.required' => 'معرف دار النشر مطلوب',
            'id_editor.exists' => 'دار النشر المحدد غير موجود',
        ];
    }
}
