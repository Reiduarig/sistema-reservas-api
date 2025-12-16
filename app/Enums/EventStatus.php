<?php

namespace App\Enums;

enum EventStatus: string
{
    case ACTIVE = 'active';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
