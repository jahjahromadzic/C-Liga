<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MatchResultType: string implements HasLabel
{
    case Played = 'played';

    /** Awarded 3:0 (par-forfe, čl. 5.13): counts for goal difference, never for scorers. */
    case Forfeit = 'forfeit';

    /** Team is free in this round (slobodna ekipa, čl. 8.6). */
    case Bye = 'bye';

    public function getLabel(): string
    {
        return match ($this) {
            self::Played => 'Odigrana',
            self::Forfeit => 'Par-forfe',
            self::Bye => 'Slobodna ekipa',
        };
    }
}
