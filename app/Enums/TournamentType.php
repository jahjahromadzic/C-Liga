<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentType: string implements HasLabel
{
    /** Regular league tournament that awards league points. */
    case Regular = 'regular';

    /** Season finale (top teams), awards no league points. */
    case Finals = 'finals';

    public function getLabel(): string
    {
        return match ($this) {
            self::Regular => 'Turnir',
            self::Finals => 'Finale',
        };
    }
}
