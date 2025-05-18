<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\UserStatus; // تأكد من استيراد الـ Enum

class UserResource extends JsonResource
{
    /**
     * تحويل النموذج إلى مصفوفة بيانات.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id_User, // افترضنا أن المفتاح الرئيسي هو id_User
            'name' => $this->name,
            'email' => $this->email,
            'status' => [
    'value' => $this->status->value,
    'label' => $this->status->getDescription(),
            ],

    
            'role' => $this->role,
            'created_at' => $this->created_at->toDateTimeString(), // التأكد من تحويل التاريخ إلى تنسيق يمكن قراءته
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
