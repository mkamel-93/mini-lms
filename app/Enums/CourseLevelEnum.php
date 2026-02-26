<?php

declare(strict_types=1);

namespace App\Enums;

enum CourseLevelEnum: string
{
    case BEGINNER = 'beginner';
    case INTERMEDIATE = 'intermediate';
    case ADVANCED = 'advanced';
}
