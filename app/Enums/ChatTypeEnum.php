<?php

declare(strict_types=1);

namespace App\Enums;

enum ChatTypeEnum: string
{
    case PRIVATE = 'private';
    case GROUP = 'group';
}
