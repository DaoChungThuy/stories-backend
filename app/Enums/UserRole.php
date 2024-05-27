<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const ADMIN = 1;
    const AUTHOR = 2;
    const USER = 3;
}
