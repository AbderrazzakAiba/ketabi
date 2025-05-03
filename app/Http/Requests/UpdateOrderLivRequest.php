<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // Import Rule
use App\Enums\OrderStatus; // Import OrderStatus
use App\Models\OrderLiv; // Import OrderLiv model

class UpdateOrderLivRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Only users with the 'update' ability on the specific OrderLiv model can make this request
        $orderLiv = $this->route('orderLiv'); // Get the OrderLiv model from the route
        return $this->user()->can('update', $orderLiv);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_user' => 'sometimes|required|exists:users,id_User',
            'id_book' => 'sometimes|required|exists:books,id_book',
            'order_date' => 'sometimes|required|date',
            'status' => ['sometimes', 'required', 'string', Rule::in(array_column(OrderStatus::cases(), 'value'))],
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
            'id_user.required' => 'معرف المستخدم مطلوب.',
            'id_user.exists' => 'المستخدم المحدد غير موجود.',
            'id_book.required' => 'معرف الكتاب مطلوب.',
            'id_book.exists' => 'الكتاب المحدد غير موجود.',
            'order_date.required' => 'تاريخ الطلب مطلوب.',
            'order_date.date' => 'تاريخ الطلب يجب أن يكون تاريخاً صالحاً.',
            'status.required' => 'حالة الطلب مطلوبة.',
            'status.string' => 'حالة الطلب يجب أن تكون نصاً.',
            'status.in' => 'حالة الطلب المدخلة غير صالحة.',
        ];
    }
}
