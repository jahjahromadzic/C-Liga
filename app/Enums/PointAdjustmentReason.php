<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PointAdjustmentReason: string implements HasLabel
{
    case NoShow = 'no_show';                       // čl. 20.6
    case FinalsNoShow = 'finals_no_show';          // čl. 7.9 (next season)
    case UnpaidMembership = 'unpaid_membership';   // čl. 3.3
    case NameChange = 'name_change';               // čl. 1.4
    case Manual = 'manual';                        // decision of the Radna grupa

    public function getLabel(): string
    {
        return match ($this) {
            self::NoShow => 'Nedolazak ekipe',
            self::FinalsNoShow => 'Izostanak s Finala',
            self::UnpaidMembership => 'Neplaćena članarina',
            self::NameChange => 'Promjena naziva ekipe',
            self::Manual => 'Odluka Radne grupe',
        };
    }
}
