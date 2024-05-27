<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusBook extends Enum
{
    const PENDING = 1;
    const ACTIVE = 2;
    const BAN = 3;
}
