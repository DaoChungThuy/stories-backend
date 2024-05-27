<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class BookType extends Enum
{
    const FREE = 1;
    const BASE = 2;
    const PREMIUM = 3;
}
