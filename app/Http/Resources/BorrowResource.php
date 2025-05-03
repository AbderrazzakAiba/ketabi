<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowResource extends JsonResource
{
    /**
     * تحويل الموارد إلى مصفوفة من البيانات.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'copy_id' => $this->copy_id,
            'type' => $this->type,
            'borrowed_at' => $this->borrowed_at,
            'due_date' => $this->due_date,
            'returned_at' => $this->returned_at,
            'status' => $this->status,
            // يمكنك إضافة أي بيانات إضافية مثل المستخدمين، الكتب، أو حالة النسخة
            'user' => $this->user, // افتراضًا أنك ترغب في إرجاع معلومات المستخدم
            'copy' => $this->copy, // إضافة النسخة المعارة
        ];
    }
}
