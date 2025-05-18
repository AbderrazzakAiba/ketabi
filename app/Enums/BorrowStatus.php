<?php

namespace App\Enums;

enum BorrowStatus: string
{
    case ACTIVE = 'active';       // الإعارة جارية
    case RETURNED = 'returned';   // تم إرجاع الكتاب
    case OVERDUE = 'overdue';     // تأخر في الإرجاع
    case CANCELLED = 'cancelled'; // ملغاة
    case PENDING_EXTENSION = 'pending_extension'; // في انتظار الموافقة على التمديد
}
