<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ChargeStatus: string implements HasLabel
{
    case Unpaid = 'unpaid';
    case Paid = 'paid';

    /** Forgiven by the Radna grupa. */
    case Waived = 'waived';

    public function getLabel(): string
    {
        return match ($this) {
            self::Unpaid => 'Neplaćeno',
            self::Paid => 'Plaćeno',
            self::Waived => 'Oprošteno',
        };
    }
}
