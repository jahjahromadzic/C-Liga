<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum CardType: string implements HasLabel
{
    case Yellow = 'yellow';
    case Red = 'red';

    public function getLabel(): string
    {
        return match ($this) {
            self::Yellow => 'Žuti karton',
            self::Red => 'Crveni karton',
        };
    }
}
