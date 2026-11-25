<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum MatchStage: string implements HasLabel
{
    case Group = 'group';
    case Knockout = 'knockout';
    case ThirdPlace = 'third_place';
    case Final = 'final';

    public function getLabel(): string
    {
        return match ($this) {
            self::Group => 'Grupna faza',
            self::Knockout => 'Kup (eliminacija)',
            self::ThirdPlace => 'Za 3. mjesto',
            self::Final => 'Finale',
        };
    }
}
