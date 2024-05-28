<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class StatusStory extends Enum
{
    const PENDING = 1;
    const ACTIVE = 2;
    const BAN = 3;
}
