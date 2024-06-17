<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class PaymentGetway extends Enum
{
    const ATM = 'ATM Payment';
    const STRIPE = 'Stripe Payment';
}
