<?php

namespace App\Enums;

enum CopyStatus: string
{
    case AVAILABLE = 'available'; // متاح للإعارة
    case ON_LOAN = 'on_loan';     // مُعار حاليًا
    case LOST = 'lost';           // مفقود
    case DAMAGED = 'damaged';     // تالف
    case IN_REPAIR = 'in_repair'; // قيد الإصلاح
}
