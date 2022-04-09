<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class UserRole extends Enum
{
    const admin = 'admin';
    const super_admin = 'super_admin';
    const shopper = 'shopper';
    const partner = 'partner';
}
