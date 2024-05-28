<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PackageType extends Enum
{
    const FREE = 1;
    const BASE = 2;
    const PREMIUM = 3;
}
