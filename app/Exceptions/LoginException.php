<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class LoginException extends Exception
{
    protected $message = 'These credentials do not match our records.';
}
