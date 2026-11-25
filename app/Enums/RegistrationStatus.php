<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum RegistrationStatus: string implements HasLabel
{
    case Registered = 'registered';

    /** Team withdrew before playing. */
    case Withdrawn = 'withdrawn';

    /** Team did not show up without a valid reason (čl. 20.6). */
    case NoShow = 'no_show';

    public function getLabel(): string
    {
        return match ($this) {
            self::Registered => 'Prijavljena',
            self::Withdrawn => 'Odustala',
            self::NoShow => 'Nije se pojavila',
        };
    }
}
