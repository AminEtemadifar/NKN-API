<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends BaseException
{
    protected $code = 401;
    protected $message = 'خطا در احراز هویت';
}
