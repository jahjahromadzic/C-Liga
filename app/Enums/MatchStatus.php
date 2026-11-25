<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MatchStatus: string implements HasLabel
{
    case Scheduled = 'scheduled';
    case Finished = 'finished';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Scheduled => 'Zakazana',
            self::Finished => 'Završena',
            self::Cancelled => 'Otkazana',
        };
    }
}
