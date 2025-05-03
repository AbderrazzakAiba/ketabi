<?php

namespace App\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';     // قيد المراجعة
    case APPROVED = 'approved';   // موافق عليه
    case REJECTED = 'rejected';   // مرفوض
    case COMPLETED = 'completed'; // تم التنفيذ
    case CANCELLED = 'cancelled'; // تم الإلغاء

    // دالة للحصول على جميع القيم
    public static function getValues(): array
    {
        return array_map(fn($enum) => $enum->value, self::cases());
    }
}
