<?php

namespace App\Models\Enums;

enum SendStatusEnum: string
{
    case ERROR = 'error';

    case SUCCESS = 'done';

    case PENDING = 'pending';
}
