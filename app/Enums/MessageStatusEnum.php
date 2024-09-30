<?php

declare(strict_types=1);

namespace App\Enums;

enum MessageStatusEnum: string
{
    case SENT = 'sent';
    case EDITED = 'edited';
    case DELETED = 'deleted';
}
