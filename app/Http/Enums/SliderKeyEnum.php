<?php

namespace App\Http\Enums;

use App\Traits\EnumToArray;

enum SliderKeyEnum: string
{
    use EnumToArray;
    case MAIN_SLIDER = 'main_slider';
    case SECTION_TWO = 'section_two';
    case SECTION_THREE = 'section_three';
}
