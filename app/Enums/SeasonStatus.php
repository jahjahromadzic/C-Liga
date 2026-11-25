<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum SeasonStatus: string implements HasLabel
{
    case Draft = 'draft';
    case Active = 'active';
    case Finished = 'finished';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'U pripremi',
            self::Active => 'Aktivna',
            self::Finished => 'Završena',
        };
    }
}
