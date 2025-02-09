<?php

namespace App\Http\Enums;

use App\Traits\EnumToArray;

enum RoleEnum: string
{
    use EnumToArray;
    case FULL_ADMIN = 'full_admin';
    case ADMIN = 'admin';
    case DOC = 'doc';

}
