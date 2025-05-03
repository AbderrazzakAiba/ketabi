<?php

namespace App\Enums;

enum LoanType: string
{
    case IN_LIBRARY = 'in_library';       // إعارة داخل المكتبة (لحظية)
    case EXTERNAL = 'external';         // إعارة خارجية (نسخة مادية)
    case ONLINE_RETURN = 'online_return'; // إعارة عبر الإنترنت (بإرجاع)
    case ONLINE_DOWNLOAD = 'online_download'; // إعارة عبر الإنترنت (تنزيل)
}
