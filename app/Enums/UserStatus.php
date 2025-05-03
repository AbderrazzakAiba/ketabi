<?php

namespace App\Enums;

enum UserStatus: string
{
    case PENDING = 'pending';     // قيد الانتظار (للموافقة)
    case APPROVED = 'approved';   // موافق عليه
    case REJECTED = 'rejected';   // مرفوض

    /**
     * إرجاع الوصف بناءً على الحالة.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return match($this) {
            self::PENDING => 'قيد الانتظار',
            self::APPROVED => 'موافق عليه',
            self::REJECTED => 'مرفوض',
        };
    }
}
