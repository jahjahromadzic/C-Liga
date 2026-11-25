<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TournamentFormat: string implements HasLabel
{
    /** Knockout (kup sistem) from the first round. */
    case Knockout = 'knockout';

    /** Group stage first, then knockout. */
    case GroupsKnockout = 'groups_knockout';

    public function getLabel(): string
    {
        return match ($this) {
            self::Knockout => 'Kup sistem',
            self::GroupsKnockout => 'Grupe + kup sistem',
        };
    }
}
