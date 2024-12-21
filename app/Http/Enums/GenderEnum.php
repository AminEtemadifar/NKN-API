<?php

namespace App\Http\Enums;

use App\Traits\EnumToArray;

enum GenderEnum: int
{
    use EnumToArray;

    case MALE = 1;
    case FEMALE = 2;
}
