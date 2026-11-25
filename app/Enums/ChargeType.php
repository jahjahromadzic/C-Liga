<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

/** Every fee or fine from the rulebook (Propozicije C-Lige). */
enum ChargeType: string implements HasLabel
{
    case Membership = 'membership';              // čl. 2.3
    case RedCard = 'red_card';                   // čl. 5.3
    case ExtraPlayer = 'extra_player';           // čl. 10.11
    case NoShow = 'no_show';                     // čl. 20.6
    case NameChange = 'name_change';             // čl. 2.4
    case FinalsNewPlayer = 'finals_new_player';  // čl. 3.9
    case FinalsNoShow = 'finals_no_show';        // čl. 7.9
    case PrizeTax = 'prize_tax';                 // čl. 1.3
    case OfficialFee = 'official_fee';           // čl. 4.3 (referee/delegate)
    case MemberCard = 'member_card';             // čl. 6.3
    case Other = 'other';

    public function getLabel(): string
    {
        return match ($this) {
            self::Membership => 'Članarina ekipe',
            self::RedCard => 'Crveni karton',
            self::ExtraPlayer => 'Igrač preko limita',
            self::NoShow => 'Nedolazak ekipe',
            self::NameChange => 'Promjena naziva ekipe',
            self::FinalsNewPlayer => 'Novi igrač za Finale',
            self::FinalsNoShow => 'Izostanak s Finala',
            self::PrizeTax => 'Taksa na nagradu (10%)',
            self::OfficialFee => 'Taksa suca/delegata',
            self::MemberCard => 'Članska kartica',
            self::Other => 'Ostalo',
        };
    }
}
