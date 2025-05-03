<?php

namespace App\Enums;

enum BookStatus: string
{
    case AVAILABLE = 'available';     // متوفر
    case UNAVAILABLE = 'unavailable'; // غير متوفر
    case ARCHIVED = 'archived';       // مؤرشف
}
