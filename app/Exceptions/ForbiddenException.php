<?php

namespace App\Exceptions;

use Exception;
use Faker\Provider\Base;

class ForbiddenException extends BaseException
{
    protected $code = 403;
    protected $message = 'عدم دسترسی';
}
