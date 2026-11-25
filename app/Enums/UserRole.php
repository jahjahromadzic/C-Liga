<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UserRole: string implements HasLabel
{
    case Admin = 'admin';
    case Delegate = 'delegate';

    public function getLabel(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::Delegate => 'Delegat',
        };
    }
}
