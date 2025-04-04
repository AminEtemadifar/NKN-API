<?php

namespace App\Http\Enums;

use App\Traits\EnumToArray;

enum BlogTypeEnum: string
{
    use EnumToArray;

    case BLOG = 'blog';
    case NEWS = 'news';
    case SOCIAL_RESPONSIBILITY = 'social_responsibility';
}
